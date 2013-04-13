<?php 

App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
App::uses('CakeNumber', 'Utility');

class UploadBehavior extends ModelBehavior {
	
/**
 * The default options for the behavior
 *
 * @var array
 * @access protected
 */	
	protected $_defaults = array(
			
		// Path to upload	
		'path' => 'files{:DS}{:MODEL}{:DS}{:FIELD}',
			
		// Fields in Model	
		'fields' => array('dir' => 'dir','filesize' => 'file_size','mimetype' => 'mime_type'),
			
		// Thumbnails options	
		'thumbnails' => array(),
			
		//@todo  Storage FileSystem|S3	
		'storage' => array()				
	);
	
/**
 * Array of files to be removed on the afterSave callback
 *
 * @var array
 * @access private
 */
	private $__filesToRemove = array();
	
/**
 * Array of all possible images that can be converted to thumbnails
 *
 * @var array
 * @access protected
 */
	private $_imageTypes = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon');	
		
	
	public function setup(Model $Model, $settings = array()) {

		foreach ($settings as $field => $options) {

			// Check if they even PASSED IN parameters
			if (!is_array($options)) {
				// You jerks!
				$field = $options;
				$options = array();
			}		

			// Merge with default options
			$this->settings[$Model->alias][$field] = Set::merge($this->_defaults, (array)$options);

			// Check if given field exists
			if ($Model->useTable && !$Model->hasField($field)) {
				throw new InvalidArgumentException(sprintf('The field "%s" doesn\'t exists in the model "%s".', $field, $Model->alias));
			}			
			
			// Check given path
			if (!empty($this->settings[$Model->alias][$field]['path'])) {
				$this->settings[$Model->alias][$field]['path'] = Folder::slashTerm(String::insert($this->settings[$Model->alias][$field]['path'], array(
						'DS' => DS,'MODEL' => strtolower($Model->alias),'FIELD' => strtolower($field)),array('before' => '{:','after' => '}')));
				new Folder(WWW_ROOT.$this->settings[$Model->alias][$field]['path'],true,0777);
			}
			
			// Check thumbnails
			if (!empty($this->settings[$Model->alias][$field]['thumbnails'])) {
				if (!class_exists('\Imagine\Gd\Imagine')) {
					throw new ErrorException('Load Imagine Lib');
				}
				foreach ($this->settings[$Model->alias][$field]['thumbnails'] as $thumb => $options) {
					if (empty($thumb) || empty($options) || empty($options['type']) || empty($options['size'])) {
						throw new InvalidArgumentException(sprintf('The thumbnail %s is invalid',$thumb));
					}
					new Folder(Folder::slashTerm(WWW_ROOT.String::insert($this->settings[$Model->alias][$field]['path']."thumb{:DS}{$thumb}", array('DS' => DS),array('before' => '{:','after' => '}'))),true,0777);										
				}
			}
		}	
	}	
	
/**
 * Before save method. Called before all saves
 *
 * Handles setup of file uploads
 *
 * @param AppModel $model Model instance
 * @return boolean
 */	
	public function beforeSave(Model $Model) {
		
		foreach ($this->settings[$Model->alias] as $field => $options) {

			// Take care of removal flagged field
			if (!empty($Model->data[$Model->alias][$field]['remove'])) {
				if (!empty($Model->data[$Model->alias][$Model->primaryKey]) || $Model->id) {
					if (empty($Model->id)) {
						$Model->id = $Model->data[$Model->alias][$Model->primaryKey];
					}
					$filename = $Model->field($field);
					if (!empty($filename)) {
						$this->__filesToRemove[] = array(
							'field' => $field,	
							'name' => $filename,
							'dir' => $options['path']	
						);						
					}
					$Model->data[$Model->alias][$field] = null;
				}				
				continue;
			}
			
			// If no file has been upload, then unset the field to avoid overwriting existant file
			if (!isset($Model->data[$Model->alias][$field]) && (empty($Model->data[$Model->alias][$field]) || !is_array($Model->data[$Model->alias][$field]))) {
				if (!empty($Model->data[$Model->alias][$Model->primaryKey]) || $Model->id) {
					unset($Model->data[$Model->alias][$field]);
				} else {
					$Model->data[$Model->alias][$field] = null;
				}				
				continue;
			}
			
			// If no file was selected we do not need to proceed
			if (empty($Model->data[$Model->alias][$field]['name'])) {
				unset($Model->data[$Model->alias][$field]);
				continue;
			}
			
			//if the record is already saved in the database, set the existing file to be removed after the save is sucessfull
			if (!empty($Model->data[$Model->alias][$Model->primaryKey]) || $Model->id) {
				if (empty($Model->id)) {
					$Model->id = $Model->data[$Model->alias][$Model->primaryKey];
				}	
				$filename = $Model->field($field);
				if (!empty($filename)) {
					$this->__filesToRemove[] = array(
						'field' => $field,
						'name' => $filename,
						'dir' => $options['path']
					);
				}
			}
			
			// Fix file name
			$File = new File(WWW_ROOT.Folder::slashTerm($options['path']).$Model->data[$Model->alias][$field]['name']);
			$Model->data[$Model->alias][$field]['name'] = String::uuid().'.'.$File->ext();
			
			
			// Move tmp file to upload dir
			if (!move_uploaded_file($Model->data[$Model->alias][$field]['tmp_name'], WWW_ROOT.$options['path'].$Model->data[$Model->alias][$field]['name'])) {
				throw new InternalErrorException('Problems in the move of the file');
			}
			
			// If the file is an image, try to make the thumbnails
			if (!empty($options['thumbnails']) /*&& in_array($Model->data[$Model->alias][$field]['type'], $this->_imageTypes)*/) {
				
				foreach ($options['thumbnails'] as $thumb => $opts) {
					list($w,$h) = explode('x', $opts['size']);
					$method = $opts['type'];
					unset($opts['type']);
					$mode = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
					$imagine = new \Imagine\Gd\Imagine();
					$image = $imagine->open(WWW_ROOT.$options['path'].$Model->data[$Model->alias][$field]['name'])
								->{$method}(new Imagine\Image\Box($w, $h),$mode)
								->save(WWW_ROOT.$options['path'].'thumb'.DS.$thumb.DS.$Model->data[$Model->alias][$field]['name']);					
				}
			}
			
			// Update model data
			if ($Model->hasField($options['fields']['dir'])) {
				$Model->data[$Model->alias][$options['fields']['dir']] = $options['path'];
			}
			if ($Model->hasField($options['fields']['mimetype'])) {			
				$Model->data[$Model->alias][$options['fields']['mimetype']] = $Model->data[$Model->alias][$field]['type'];
			}
			if ($Model->hasField($options['fields']['filesize'])) {			
				$Model->data[$Model->alias][$options['fields']['filesize']] = $Model->data[$Model->alias][$field]['size'];
			}
			$Model->data[$Model->alias][$field] = $Model->data[$Model->alias][$field]['name'];
		}
		
		return true;
	}
	
/**
 * After save (callback)
 *
 * @param object $model Reference to model
 * @return void
 * @access public
 */
	public function afterSave(Model $Model) {
		$this->_deleteFilesList($Model);
	}
	
/**
 * Deletes all files associated with the record beforing delete it.
 *
 * @param object $model Reference to model
 * @return boolean Always true
 * @access public
 */
	function beforeDelete(Model $Model) {
		$data = $Model->read(null, $Model->id);
		if (!empty($data)) {
			foreach ($this->settings[$Model->alias] as $field => $options) {
				if (!empty($data[$Model->alias][$field])) {
					$this->__filesToRemove[] = array(
						'field' => $field,
						'name' => $data[$Model->alias][$field],
						'dir' => $options['path']
					);
				}				
			}
		}
		return true;
	}	

/**
 * After delete (callback)
 *
 * @param object $model Reference to model
 * @return void
 * @access public
 */
	function afterDelete(Model $Model) {
		$this->_deleteFilesList($Model);
	}	

	public function beforeValidate(Model $Model) {

		return true;
	}
	
/**
 * Checks if the file isn't bigger then the max file size option.
 *
 * @param object $model Reference to model
 * @param array $data
 * @return boolean
 * @access public
 */
	function maxSize(Model $Model, $check, $maxSize) {

		$maxSize = CakeNumber::fromReadableSize($maxSize);

		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (!empty($value['name']) && !empty($this->settings[$Model->alias][$field])) {
			return ($value['size'] < $maxSize); 
		}
		
		return true;
	}	
	
/**
 * Checks if the file has an allowed extension.
 *
 * @param object $model Reference to model
 * @param array $data
 * @return boolean
 * @access public
 */
	function ext(Model $Model, $check, $allowed) {

		if (empty($allowed) || isset($allowed['rule'])) {
			$allowed = array('jpg','jpeg','png','gif','bmp','ico');
		}
		
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (!empty($value['name']) && !empty($this->settings[$Model->alias][$field])) {			
			$File = new File($value['name']);
			return (in_array(strtolower($File->ext()),$allowed));			
		}
		
		return true;
	}

/**
 * Checks if the file is of an allowed mime-type.
 *
 * @param object $model Reference to model
 * @param array $data
 * @return boolean
 * @access public
 */
	function mimeType(Model $Model, $check, $allowed) {

		if (empty($allowed) || isset($allowed['rule'])) {
			$allowed = $this->_imageTypes;
		}
		
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (!empty($value['name']) && !empty($this->settings[$Model->alias][$field])) {
			return in_array($value['type'], $allowed);
		}		
				
		return true;
	}	
	
/**
 * Checks if the min width is allowed
 *
 * @param object $model Reference to model
 * @param array $data
 * @return boolean
 * @access public
 */
	function minWidth(Model $Model, $check, $min) {
		
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (!empty($value['name']) && !empty($this->settings[$Model->alias][$field]) && in_array($value['type'], $this->_imageTypes)) {
			$imagine = new \Imagine\Gd\Imagine();
			$size = $imagine->open($value['tmp_name'])->getSize();
			return ($size->getWidth() > intval($min));			
		}
		
		return true;		
	}
	
/**
 * Checks if the max width is allowed
 *
 * @param object $model Reference to model
 * @param array $data
 * @return boolean
 * @access public
 */
	function maxWidth(Model $Model, $check, $max) {
		
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (!empty($value['name']) && !empty($this->settings[$Model->alias][$field]) && in_array($value['type'], $this->_imageTypes)) {
			$imagine = new \Imagine\Gd\Imagine();
			$size = $imagine->open($value['tmp_name'])->getSize();
			return ($size->getWidth() < intval($max));				
		}
		
		return true;		
	}
	
/**
 * Checks if the min height is allowed
 *
 * @param object $model Reference to model
 * @param array $data
 * @return boolean
 * @access public
 */
	function minHeight(Model $Model, $check, $min) {
		
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (!empty($value['name']) && !empty($this->settings[$Model->alias][$field]) && in_array($value['type'], $this->_imageTypes)) {
			$imagine = new \Imagine\Gd\Imagine();
			$size = $imagine->open($value['tmp_name'])->getSize();
			return ($size->getHeight() > intval($min));				
		}
		
		return true;		
	}
	
/**
 * Checks if the max height is allowed
 *
 * @param object $model Reference to model
 * @param array $data
 * @return boolean
 * @access public
 */
	function maxHeight(Model $Model, $check, $max) {
		
		$value = array_values($check);
		$value = $value[0];
		$field = key($check);
		
		if (!empty($value['name']) && !empty($this->settings[$Model->alias][$field]) && in_array($value['type'], $this->_imageTypes)) {
			$imagine = new \Imagine\Gd\Imagine();
			$size = $imagine->open($value['tmp_name'])->getSize();
			return ($size->getHeight() < intval($max));				
		}
		
		return true;		
	}	
	
/**
 * Deletes the files marked to be deleted in the save method.
 * A file can be marked to be deleted if it is overwriten by
 * another or if the user mark it to be deleted.
 *
 * @param object $model Reference to model
 * @return void
 * @access protected
 */	
	protected function _deleteFilesList($Model) {
		foreach ($this->__filesToRemove as $file) {
			if (!empty($file['name'])) {
				$File = new File(WWW_ROOT.Folder::slashTerm($file['dir']).$file['name']);
				$File->delete();
				if (!empty($this->settings[$Model->alias][$file['field']]['thumbnails'])) {
					foreach ($this->settings[$Model->alias][$file['field']]['thumbnails'] as $thumb => $options) {
						$File = new File(WWW_ROOT.Folder::slashTerm($file['dir']).'thumb'.DS.$thumb.DS.$file['name']);
						$File->delete();
					}
				}
			}
		}
		// Reset the filesToRemove array
		$this->__filesToRemove = array();		
	}
}
