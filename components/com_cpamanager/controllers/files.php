<?php
/**
 * @version     1.0.0
 * @package     com_metikaccmgr
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomlavi <info@joomlavi.com> - http://www.joomlavi.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');
jimport('joomla.filesystem.folder');
                        jimport('joomla.filesystem.file');
/**
 * Files list controller class.
 */
class CPAManagerControllerFiles extends JControllerAdmin
{
    public function __construct($config = array()){
        parent::__construct($config);
        $this->input = JFactory::getApplication()->input;
    }

    public function getModel($name = 'file', $prefix = 'CPAManagerModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }

    public function getFolder(){
	
        $ctn = $this->input->get('ctn','','string');
        $path = $this->input->get('path','','string');
        if($path) $path .= '/';
        $absolutePath = JPATH_SITE.'/'.jSont::getDirPath($ctn).'/'.$path;

        $returnFolders = array();
        if($folders = JFolder::folders($absolutePath)) foreach($folders as $folder){
            $returnFolders[] = array('name'=>$folder, 'path'=>$path.$folder);
        }
        $returnFiles = array();
        if($files = JFolder::files($absolutePath)) foreach($files as $file){
            if($file != 'index.html') $returnFiles[] = array('name'=>$file, 'path'=>$path.$file);
        }
        exit(json_encode(array('childs'=>$returnFolders, 'files'=>$returnFiles)));
    }

    public function upload(){
        if(isset($_FILES['file'])){
            $ctn = $this->input->get('ctn','','string');
            $ctn_type = $this->input->get('ctn_type','','string');

            $file = $_FILES['file'];
            if(isset($_REQUEST['name'])){
                $fileName = jSont::sanitizeFileName($_REQUEST['name']);
            }else{
                $fileName = jSont::sanitizeFileName($file['name']);
            }

            $check = jSont::checkFileUpload($file, $ctn_type);
            if($check === true){
                $path = $this->input->get('path','','string');
                if($path) $path .= '/';
                $absolutePath = JPATH_SITE.'/'.jSont::getDirPath($ctn).'/'.$path;

                
                
                if(!is_dir($absolutePath)) JFolder::create ($absolutePath);
                if(is_file($absolutePath.$fileName)){
                    exit(json_encode(array('rs'=>false, 'msg'=>JText::_('File exists'))));
                }
                if(!JFile::upload($file['tmp_name'], $absolutePath.$fileName)){
                    exit(json_encode(array('rs'=>false, 'msg'=>JText::_('File upload is error.....'))));
                }
                else{
                    @unlink($file['tmp_name']);
                    exit(json_encode(array('rs'=>true, 'file'=>array('name'=>$fileName, 'path'=>$path.$fileName))));
                }
            }else{
                exit(json_encode(array('rs'=>false, 'msg'=>$check)));
            }
        }else{
            exit(json_encode(array('rs'=>false, 'msg'=>JText::_('File not found'))));
        }
    }

    public function createFolder(){
        $ctn = $this->input->get('ctn','','string');
        $path = $this->input->get('path','','string');
        $name = $this->input->get('name','','string');
        if($path) $path .= '/';
        $absolutePath = JPATH_SITE.'/'.jSont::getDirPath($ctn).'/'.$path.$name;

        if(is_dir($absolutePath)){
            exit(json_encode(array('rs'=>false, 'msg'=>JText::_('COM_CLIENTROL_MSG_FOLDER_EXISTED'))));
        }
        JFolder::create($absolutePath);
        exit(json_encode(array('rs'=>true, 'name'=>$name, 'path'=>$path.$name)));
    }

    public function deleteFolder(){
        $ctn = $this->input->get('ctn','','string');
        $path = $this->input->get('path','','string');
        if($path){
            $path .= '/';
            $absolutePath = JPATH_SITE.'/'.jSont::getDirPath($ctn).'/'.$path;
            if(is_dir($absolutePath)){
                $folders = JFolder::folders($absolutePath);
                $files = JFolder::files($absolutePath);
                if($folders || $files) exit(json_encode(array('rs'=>false, 'msg'=>JText::_('COM_CLIENTROL_MSG_FOLDER_NOT_EMPTY'))));
                JFolder::delete($absolutePath);
            }
        }
        exit(json_encode(array('rs'=>true)));
    }

    public function getFile(){
        $ctn = $this->input->get('ctn','','string');
        $path = $this->input->get('path','','string');
        $absolutePath = JPATH_SITE.'/'.jSont::getDirPath($ctn).'/'.$path;

        if(!is_file($absolutePath)){
            exit(json_encode(array('rs'=>false, 'msg'=>JText::_('COM_METIKACCMGR_MSG_FILE_NOT_FOUND'))));
        }

        $fileType = jSont::getFileType($absolutePath);
        $file['type'] = $fileType['type'];
        $file['icon'] = $fileType['icon'];
        $file['extension'] = $fileType['extension'];
        $file['url'] = JUri::root().jSont::getDirPath($ctn).'/'.$path;
        $file['url_encode'] = urlencode(JUri::root().jSont::getDirPath($ctn).'/'.$path);
        $file['size'] = jSont::formatFileSize(filesize($absolutePath));
        if($file['type'] == 'image') list($file['width'], $file['height']) = @getimagesize($absolutePath);
        exit(json_encode(array('rs'=>true, 'file'=>$file)));
    }

    public function deleteFile(){
        $ctn = $this->input->get('ctn','','string');
        $path = $this->input->get('path','','string');
        $absolutePath = JPATH_SITE.'/'.jSont::getDirPath($ctn).'/'.$path;
        if(is_file($absolutePath)){
            JFile::delete($absolutePath);
        }
        exit(json_encode(array('rs'=>true)));
    }

    public function getUrl(){
        $url = $this->input->get('url','','string');
        $data = array(
            'url' => $url,
            'size' => false,
            'name' => basename($url)
        );

        if (!function_exists('curl_init')) {
            exit(json_encode(array('rs'=>false, 'msg'=>JText::_('COM_CLIENTROL_MSG_CURL_NOT_EXIST'))));
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $data['url']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS,		 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 		 20);
        //CURLOPT_NOBODY changes the request from GET to HEAD
        curl_setopt($ch, CURLOPT_NOBODY, 		 true);
        curl_exec($ch);
        if (curl_errno($ch)) exit(json_encode(array('rs'=>false, 'msg'=>JText::sprintf('COM_CLIENTROL_MSG_CURL_ERROR', curl_error($ch)))));

        $info = curl_getinfo($ch);
        if (isset($info['http_code']) && $info['http_code'] != 200) exit(json_encode(array('rs'=>false, 'msg'=>JText::sprintf('COM_CLIENTROL_MSG_URL_NOT_FOUND', $data['url'], $info['http_code']))));
        if (isset($info['download_content_length'])) $data['size'] = jSont::formatFileSize($info['download_content_length']);
        else exit(json_encode(array('rs'=>false, 'msg'=>JText::_('COM_METIKACCMGR_MSG_FILE_NOT_FOUND'))));
        curl_close($ch);

        exit(json_encode(array('rs'=>true, 'file'=>$data)));
    }

    public function uploadFromUrl(){
        $ctn = $this->input->get('ctn','','string');
        $ctn_type = $this->input->get('ctn_type','','string');
        $path = $this->input->get('path','','string');
        if($path) $path .= '/';
        $absolutePath = JPATH_SITE.'/'.jSont::getDirPath($ctn).'/'.$path;

        $url = $this->input->get('url','','string');
        $fileName = $this->input->get('name','','string');

        if(!jSont::checkFileType($fileName, $ctn_type)) exit(json_encode(array('rs'=>false, 'msg'=>JText::_('Invalid Type'))));
        if(!is_dir($absolutePath)) exit(json_encode(array('rs'=>false, 'msg'=>JText::_('Folder not found'))));
        if(is_file($absolutePath.$fileName)) exit(json_encode(array('rs'=>false, 'msg'=>JText::_('File is existed'))));
        if (!function_exists('curl_init')) exit(json_encode(array('rs'=>false, 'msg'=>JText::_('CURL not found'))));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.xcontest.org");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        if (curl_errno($ch)) exit(json_encode(array('rs'=>false, 'msg'=>JText::sprintf('CURL not found2', curl_error($ch)))));
        curl_close($ch);

        if(!JFile::write($absolutePath.$fileName, $response)) exit(json_encode(array('rs'=>false, 'msg'=>JText::_('CURL not found1'))));
        exit(json_encode(array('rs'=>true, 'file'=>array('name'=>$fileName, 'path'=>$path.$fileName))));
    }

    public function download(){
        $file = urldecode($this->input->getString('url'));
        jSont::downloadFile($file);
    }
}