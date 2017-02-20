<?php
/**
* 
* This script can be used to generate "self-executing" .php Files.
* example (require this file or autoload webfan\MimeStubAPC:
* 
* Dowload an example implementation at http://www.webfan.de/install/
* 
* 
*   $vm = \webfan\MimeStubAPC::vm();
* 
* // echo print_r($vm, true);
* 
* $newFile = __DIR__. DIRECTORY_SEPARATOR . 'TestMimeStubAPC.php';
* 
* 
* $a = <<<PHPE
* 
* echo ' TEST-modified.';
* 
* PHPE;
* 
* 
* $stub = $vm->get_file($vm->document, '$HOME/index.php', 'stub index.php')
* // ->clear()
*   ->append($a)
* ;
* 
*  $vm->to('hello@wor.ld');
*  $vm->from('me@localhost');
*  $stub->from('hello@wor.ld');  
*     
* $vm->location = $newFile;
* require $newFile;
* $run($newFile);
*  
** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** 
**
 * Copyright  (c) 2017, Till Wehowski
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of frdl/webfan nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY frdl/webfan ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL frdl/webfan BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
* 
* 
* 
* 
** includes edited version of:
*  https://github.com/Riverline/multipart-parser 
* 
* Class Part
* @package Riverline\MultiPartParser
* 
*  Copyright (c) 2015-2016 Romain Cambien
*  
*  Permission is hereby granted, free of charge, to any person obtaining a copy
*  of this software and associated documentation files (the "Software"),
*  to deal in the Software without restriction, including without limitation
*  the rights to use, copy, modify, merge, publish, distribute, sublicense,
*  and/or sell copies of the Software, and to permit persons to whom the Software
*  is furnished to do so, subject to the following conditions:
*  
*  The above copyright notice and this permission notice shall be included
*  in all copies or substantial portions of the Software.
*  
*  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
*  INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
*  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
*  IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
*  DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
*  ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
*  OTHER DEALINGS IN THE SOFTWARE.
* 
*  - edited by webfan.de
*/
namespace webfan\InstallShield\MimeStubAPC262083754;
use frdl;;





 $run = function($file = null){
 	$args = func_get_args();
 	header_remove();
 	$MimeVM = new MimeVM($args[0]);
 	$MimeVM('run');
 	return $MimeVM;
 };
 
 
$included_files = get_included_files();  
if((!defined('___BLOCK_WEBFAN_MIME_VM_RUNNING_STUB___') || false === ___BLOCK_WEBFAN_MIME_VM_RUNNING_STUB___) && (!in_array(__FILE__, $included_files) || __FILE__===$included_files[0])) {
    $run(__FILE__);
} 

  

class Context
{
	
}


class Env
{
	
}


class Response
{
	
}





 class MimeVM
 {
 	
 	
 	public $e_level = E_USER_ERROR;
 	
 	protected $Request = false;
  	protected $Response = false;	
 	
 	protected $raw = false;
 	protected $MIME = false;
 	
 	protected $__FILE__ = false;
 	protected $buf;
 	
 	//stream
 	protected $IO = false;
 	protected $file = false;
 	protected $host = false;
 	protected $mode = false;
 	protected $offset = false;
 	
 	
 	protected $Context = false; 	
 	protected $Env = false;
 	
 	protected $initial_offset = 0;
 	
 	protected $php = array();
 	
 
 
    protected $mimes_engine = array(
         'application/vnd.frdl.script.php' => '_run_php_1',
         'application/php' => '_run_php_1',
         'text/php' => '_run_php_1',
         'php' => '_run_php_1',
         'multipart/mixed' => '_run_multipart',
         'multipart/serial' => '_run_multipart',
         'multipart/related' => '_run_multipart',
         'application/x-httpd-php' => '_run_php_1',
    );

	protected function _run_multipart($_Part){

		 	foreach( $_Part->getParts() as $pos => $part){
		 		if(isset($this->mimes_engine[$part->getMimeType()])){
					call_user_func_array(array($this, $this->mimes_engine[$part->getMimeType()]), array($part));
				}
    	    }

	}

  	protected function runStubs(){

	  foreach( $this->document->getParts() as $rootPos => $rootPart){
          if($rootPart->isMultiPart())	{
		 	foreach( $rootPart->getParts() as $pos => $part){
		 		if(isset($this->mimes_engine[$part->getMimeType()])){
					call_user_func_array(array($this, $this->mimes_engine[$part->getMimeType()]), array($part));
				}
    	    }
		  }
		  break;
       }
		
		
	 }



    public function get_file($part, $file, $name){
    	
      if($file === $part->getFileName() || $name === $part->getName()){
	  	   	  $_f = &$part;
		   	  return $_f;
	  }	
    	
      if($part->isMultiPart())	{
        foreach( $part->getParts() as $pos => $_part){
            $_f = $this->get_file($_part, $file, $name);
            if(false !== $_f)return $_f;
        }	
      } 
	  return false;
	}

	public function Autoload($class){
          $fnames = array( 
                  '$LIB/'.str_replace('\\', '/', $class).'.php',
                   str_replace('\\', '/', $class).'.php',
                  '$DIR_PSR4/'.str_replace('\\', '/', $class).'.php',
                  '$DIR_LIB/'.str_replace('\\', '/', $class).'.php',
           );
           
           $name = 'class '.$class;
           
          foreach($fnames as $fn){
		  	$_p = $this->get_file($this->document, $fn, $name);
		  	if(false !== $_p){
				$this->_run_php_1($_p);
				return $_p;
			}
		  } 
           
        return false;   
	}
	 
	 
	public function _run_php_1($part){
				
		$code = $part->getBody();
		$code = trim($code);
		$code = trim($code, '<?>php ');
		eval($code);
	}
	 
	 	
 	public function __construct($file = null, $offset = 0){
 		$this->buf = &$this;
 		
 	 	if(null===$file)$file=__FILE__;
 	 	$this->__FILE__ = $file;
 	 	if(__FILE__===$this->__FILE__){
			$this->offset = $this->getAttachmentOffset(); 
		}else{
			$this->offset = $offset;
		}

        $this->initial_offset = $this->offset;
		
		
		//$this->php = array(
		//     '<?' => array(
		//     
		//     ),
		//     '#!' => array(
		//     
		 //    ),
		//     '#' => array(
		//     
		 //    ),
		//);
		
	//	MimeStubApp::God()->addStreamWrapper( 'frdl', 'mime', $this,  true  ) ;
 	}
 	
 	
 	
 	
 	final public function __destruct(){
			
		try{
			 if(is_resource($this->IO))fclose($this->IO);

		}catch(\Exception $e){
			trigger_error($e->getMessage(). ' in '.__METHOD__,  $this->e_level);
		}
	}
	
	
	
	
   public function __set($name, $value)
    {
    	if('location'===$name){
    		$code =$this->__toString();
			file_put_contents($value, $code);
			return null;
		}
    	
         $trace = debug_backtrace();
         trigger_error(
            'Undefined property via __set(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
            
            
         return null;
    }    
    	 
	 
	 
    public function getAttachmentOffset(){
	    return __COMPILER_HALT_OFFSET__;
    } 
    
    
   public function __toString()
   {
 	 	  // 	$document = $this->document;	
	 		  $code = $this->exports;	
	 		  if(__FILE__ === $this->__FILE__) 	{
			   	 $php = substr($code, 0, $this->getAttachmentOffset());
			  }else{
			  	 $php = substr($code, 0, $this->initial_offset);
			  }
	 		 
	 		 
	 		 // $php = str_replace('define(\'___BLOCK_WEBFAN_MIME_VM_RUNNING_STUB___\', true);', 'define(\'___BLOCK_WEBFAN_MIME_VM_RUNNING_STUB___\', false);', $php);
    		$php = str_replace('define(\'___BLOCK_WEBFAN_MIME_VM_RUNNING_STUB___\', true);', '', $php);
    		
      		
    		$newClassName = "webfan\InstallShield\MimeStubAPC".mt_rand(1000000,999999999);
    	    $php = preg_replace("/((\r\n|\r|\n)?namespace\swebfan;(\r\n|\r|\n)use\sfrdl;(\r\n|\r|\n))/", "\r\nnamespace ".$newClassName.";\r\n"."use frdl;".";\r\n", $php);
             
           
              $mime = $this->document;
    
           

	 	return $php.$mime;
   }   
     
  public function __get($name)
    {

     switch($name){
	 	case 'exports':	 
	 		return $this->getFileAttachment($this->__FILE__, 0);
	 	break;
	 	case 'location':	 
	 		return $this->__FILE__;
	 	break;
	 	case 'document':
	 		if(false===$this->raw){
	 			$this->raw=$this->getFileAttachment($this->__FILE__, $this->initial_offset);
	 		}
	 		if(false===$this->MIME){
	 			$this->MIME=MimeStubAPC::create($this->raw);
	 		}
	 		return $this->MIME;
	 	break;
	 	
	 	
	 	case 'request':	 
	 		return $this->Request;
	 	break;
	 		
	 	case 'context':	 
	 		return $this->Context;
	 	break;
	 		
	 	case 'response':	 
	 		return $this->Response;
	 	break;
	 	
	 	default:
         return null;	 	
	 	break;
	 }

         $trace = debug_backtrace();
         trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
            
            
         return null;
    }
   
   
	
    public function __invoke()
    {
    	$args = func_get_args();
 	
	 		if(false===$this->raw){
	 			$this->raw=$this->getFileAttachment($this->__FILE__, $this->initial_offset);
	 		}
	 		if(false===$this->MIME){
	 			$this->MIME=MimeStubAPC::create($this->raw);
	 		}
 		
		   	
 		$this->Request = new Request();
 		$this->Env = new Env();
		$this->Context = new Context();
		$this->Response = new Response();
		$res = &$this;
		
        if(0<count($args)){
        $i=-1;
		foreach($args as $arg){
		  $i++;
		  	
				if(is_object($arg) && get_class($this->Request)===get_class($arg)){
					$this->Request = &$arg;
				}elseif(is_object($arg) && get_class($this->Env)===get_class($arg)){
					$this->Env = &$arg;
				}elseif(is_object($arg) && get_class($this->Context)===get_class($arg)){
					$this->Context = &$arg;
				}elseif(is_object($arg) && get_class($this->Response)===get_class($arg)){
					$this->Response = &$arg;
				}
				
	    if(is_array($arg)){
             $this->Context = new Context($arg);
		}if(is_string($arg)){
    		$cmd = $arg;
    		if('run'===$arg){
				$res = call_user_func_array(array($this, '_run'), $args);
			}else{
    		
			$u = parse_url($cmd);
			$c = explode('.',$u['host']);
		    $c = array_reverse($c);
		    $tld = array_shift($c);
		    $f = false;
			if('frdl'===$u['scheme']){
				if('mime'===$tld){
					if(!isset($args[$i+1])){
						$res = $this->getFileAttachment($cmd, 0);
						$f = true;
					}else if(isset($args[$i+1])){
						//@todo write
					}
				}
			}	
			
			 if(false===$f){
			 	//todo...
			 	//if('#'===substr($cmd, 0, 1)){
               //      $this->php['#'][]=$cmd;
				//}elseif('#!'===substr($cmd, 0, 2)){
				//     $this->php['#!'][]=$cmd;
				//}elseif('<?'===substr($cmd, 0, 2)){
				//    $this->php['<?'][]=$cmd;
				//}else{
			 		$parent = (isset($this->MIME->parent) && null !== $this->MIME->parent) ? $this->MIME->parent : null;
					$this->MIME=MimeStubAPC::create($cmd, $parent);					
			//	}
			 }
			}

		}			
				
			}
		}elseif(0===count($args)){
			$res = &$this->buf;
		}
				      	

 	
    	
       return $res;
    }      
 	protected function _run(){
 	    $this->runStubs();
 	 	return $this;
 	} 	
 	
   public function __call($name, $arguments)
    {
    	
 	  return call_user_func_array(array($this->document, $name), $arguments);

    }
	
	
 

    public function getFileAttachment($file = null, $offset = null){
    	if(null === $file)$file = &$this->file;
    	if(null === $offset)$offset = $this->offset;
    	
		$IO = fopen($file, 'r');
		
        fseek($IO, $offset);
        try{
			$buf =  stream_get_contents($IO);
			if(is_resource($IO))fclose($IO);
		}catch(\Exception $e){
			$buf = '';
			if(is_resource($IO))fclose($IO);
			trigger_error($e->getMessage(),  $this->e_level);
		}
        
        return $buf;
	}	
	
	
   
 }




 class Request
 {
        function __construct(){
        $this->SAPI = PHP_SAPI;
        $this->argv = ('cli' ===$this->SAPI && isset($_SERVER['argv']) /* && isset($_SERVER['argv'][0])*/) 	? $_SERVER['argv'][0] : false;
       	$this->protocoll = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->server_name = $_SERVER['SERVER_NAME'];
		$this->origin = $_SERVER['HTTP_ORIGIN'];
		$this->get = $_GET;
		$this->post = $_POST;
		$this->cookies = $_COOKIE;
		$this->session = $_SESSION;
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->parsed = parse_url($this->protocoll.'://'.$this->server_name.$this->uri);
		switch($this->method){
		       case 'HEAD' :
		       case 'GET' :
		           $this->request = $_GET;
		          break;
		        case 'POST' : 
		        case 'PUT' : 
		        case 'DELETE' : 
		           $this->request = $_POST;
		          break;
		        default : 
		            $this->request = $_REQUEST;	
		          break;	
		}
		
		$this->headers = $this->getAllHeaders();
      }
    


   public function getAllHeaders()
    {
       $headers = '';
       foreach ($_SERVER as $name => $value)
       {
           if (substr($name, 0, 5) == 'HTTP_')
           {
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
           }
       }
       return $headers;
    }  
    
         
 }

/**
*  https://github.com/Riverline/multipart-parser 
* 
* Class Part
* @package Riverline\MultiPartParser
* 
*  Copyright (c) 2015-2016 Romain Cambien
*  
*  Permission is hereby granted, free of charge, to any person obtaining a copy
*  of this software and associated documentation files (the "Software"),
*  to deal in the Software without restriction, including without limitation
*  the rights to use, copy, modify, merge, publish, distribute, sublicense,
*  and/or sell copies of the Software, and to permit persons to whom the Software
*  is furnished to do so, subject to the following conditions:
*  
*  The above copyright notice and this permission notice shall be included
*  in all copies or substantial portions of the Software.
*  
*  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
*  INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
*  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
*  IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
*  DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
*  ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
*  OTHER DEALINGS IN THE SOFTWARE.
* 
*  - edited by webfan.de
*/


 
class MimeStubAPC
{
 const NS = __NAMESPACE__;
 const DS = DIRECTORY_SEPARATOR;
 const FILE = __FILE__;
 const DIR = __DIR__;
		
 const numbers = '0123456789';
 const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
 const specials = '!$%^&*()_+|~-=`{}[]:;<>?,./';
 
 
 
 	
	protected static $__i = -1;


	//protected $_parent;
    
    
    protected $_id = null;
    protected $_p = -1;   
    
    
    /**
     * @var array
     */
    protected $headers;

    /**
     * @var string
     */
    protected $body;
    
    protected $_parent = null;

    /**
     * @var Part[]
     */
    protected $parts = array();

    /**
     * @var bool
     */
    protected $multipart = false;


    protected $modified = false;
    
    protected $contentType = false;
    protected $encoding = false;
    protected $charset = false;
    protected $boundary = false;
    

   
   
   
protected function _defaultsRandchars ($opts = array()) {
  $opts = array_merge(array(
      'length' =>  8,
      'numeric' => true,
      'letters' => true,
      'special' => false
  ), $opts);
  return array(
    'length' =>  (is_int($opts['length'])) ? $opts['length'] : 8,
    'numeric' => (is_bool($opts['numeric'])) ? $opts['numeric'] : true,
    'letters' => (is_bool($opts['letters'])) ? $opts['letters'] : true,
    'special' =>  (is_bool($opts['special'])) ? $opts['special'] : false
  );
}

protected function _buildRandomChars ($opts = array()) {
   $chars = '';
  if ($opts['numeric']) { $chars .= self::numbers; }
  if ($opts['letters']) { $chars .= self::letters; }
  if ($opts['special']) { $chars .= self::specials; }
  return $chars;
}

public function generateBundary($opts = array()) {
  $opts = $this->_defaultsRandchars($opts);
  $i = 0;
  $rn = '';
      $rnd = '';
      $len = $opts['length'];
      $randomChars = $this->_buildRandomChars($opts);
  for ($i = 1; $i <= $len; $i++) {
  	$rn = mt_rand(0, strlen($randomChars) -1);
  	$n = substr($randomChars, $rn,  1);
    $rnd .= $n;
  }
 
 return $rnd;
}   
    
    
    public function __set($name, $value)
    {
         $trace = debug_backtrace();
         trigger_error(
            'Undefined property via __set(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
            
            
         return null;
    }    
    
    
  public function __get($name)
    {
       // echo "Getting '$name'\n";
      //  if (array_key_exists($name, $this->data)) {
      //      return $this->data[$name];
      //  }
     switch($name){
     	case 'disposition' :
     	    return $this->getHeader('Content-Disposition');
     	    break;
	 	case 'parent':	 
	 		return $this->_parent;
	 	break;
	 	case 'id':	 
	 		return $this->_id;
	 	break;
	 	case 'nextChild':	
	 	    $this->_p=++$this->_p;
	 	    if($this->_p >= count($this->parts)/* -1*/)return false; 
	 		return (is_array($this->parts)) ? $this->parts[$this->_p] : null;
	 	break;
	 	case 'next':	 
	 		return $this->nextChild;
	 	break;
	 	case 'rewind':	 
	 	    $this->_p=-1;
	 		return $this;
	 	case 'root':	 
	 	    if(null === $this->parent || (get_class($this->parent) !== get_class($this)))return $this;
	 		return $this->parent->root;
	 	break;
	 	case 'isRoot':	 
	 		return ($this->root->id === $this->id) ? true : false;
	 	break;
	 	case 'lastChild':	 
	 		return (is_array($this->parts)) ? $this->parts[count($this->parts)-1] : null;
	 	break;
	 	case 'firstChild':	 
	 		return (is_array($this->parts) && isset($this->parts[0])) ? $this->parts[0] : null;
	 	break;
	 	
	 	
	 	default:
         return null;	 	
	 	break;
	 }

         $trace = debug_backtrace();
         trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
            
            
         return null;
    }
   
   
     protected function _hashBody(){
        if($this->isMultiPart()){
		//   $this->setHeader('Content-MD5', md5($this));
	 	//   $this->setHeader('Content-SHA1', sha1($this));
		} else{
		   $this->setHeader('Content-MD5', md5($this->body));
	 	   $this->setHeader('Content-SHA1', sha1($this->body));
	 	   $this->setHeader('Content-Length', strlen($this->body));
	 	} 
	 }
    
     protected function _hashBodyRemove(){
		   $this->removeHeader('Content-MD5');
	 	   $this->removeHeader('Content-SHA1');
	 	   $this->removeHeader('Content-Length');
	 }
	 
	      
     public function __call($name, $arguments)
    {
    	
    	if('setBody'===$name){
    		$this->clear();
    		if(!isset($arguments[0]))$arguments[0]='';
    		$this->prepend($arguments[0]);
            return $this;	 
		}elseif('prepend'===$name){
    		if(!isset($arguments[0]))$arguments[0]='';
    		if($this->isMultiPart()){
	    		$this->parts[] = new self($arguments[0], $this);
		    	return $this;				
			}else{
				$this->body = $arguments[0] . $this->body;
				$this->_hashBody();
				return $this;		
			}

		}elseif('append'===$name){
    		if(!isset($arguments[0]))$arguments[0]='';
    		if($this->isMultiPart()){
	    		$this->parts[] = new self($arguments[0], $this);
		    	return $this;				
			}else{
				$this->body .= $arguments[0];
				$this->_hashBody();
				return $this;		
			}

		}elseif('clear' === $name){
			if($this->isMultiPart()){
				$this->parts = array();
			}else{
				$this->body = '';
				$this->_hashBodyRemove();
			}
			return $this;
		}else{
			

		
		
		
    //https://tools.ietf.org/id/draft-snell-http-batch-00.html
    foreach(array('from', 'to', 'cc', 'bcc', 'sender', 'subject', 'reply-to'/* ->{'reply-to'}  */, 'in-reply-to',
    'message-id') as $_header){
      	if($_header===$name){
            if(0===count($arguments)){
				return $this->getHeader($_header, null);
			}elseif(null===$arguments[0]){
				$this->removeHeader($_header);
			}elseif(isset($arguments[0]) && is_string($arguments[0])){
            	$this->setHeader($_header, $arguments[0]);
            }
           return $this;		
		}  
    }	
	
   
   } 
   //else
   
    	
        // Note: value of $name is case sensitive.
         $trace = debug_backtrace();
         trigger_error(
            'Undefined property via __call(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
            
            
         return null;
    }

    /**  As of PHP 5.3.0  */
    public static function __callStatic($name, $arguments)
    {
    	
     	if('run'===$name){
			return call_user_func_array('run', $arguments);
		}
    	   	
    	
     	if('vm'===$name){
     		if(0===count($arguments)){
				return new MimeVM();
			}elseif(1===count($arguments)){
				return new MimeVM($arguments[0]);
			}elseif(2===count($arguments)){
				return new MimeVM($arguments[0], $arguments[1]);
			}
     	  // return call_user_func_array(array(webfan\MimeVM, '__construct'), $arguments);
     	   return new MimeVM();
		}
    	
	
    	
    	 if('create'===$name){
    	 	if(!isset($arguments[0]))$arguments[0]='';
    	 	if(!isset($arguments[1]))$arguments[1]=null;
		 	return new self($arguments[0], $arguments[1]);
		 }
        // Note: value of $name is case sensitive.
         $trace = debug_backtrace();
         trigger_error(
            'Undefined property via __callStatic(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
            
            
         return null;
    }  
   
    public function getContentType()
    {
    	$this->contentType=$this->getMimeType();
        return $this->contentType;
    }
    
    
    public function headerName($headName)
    {
      $headName = str_replace('-', ' ', $headName);
      $headName = ucwords($headName);
      return preg_replace("/\s+/", "\s", str_replace(' ', '-', $headName));
    }
 
 


    /**
     * @param string $input A base64 encoded string
     *
     * @return string A decoded string
     */
    public static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * @param string $input Anything really
     *
     * @return string The base64 encode of what you passed in
     */
    public static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
    
    
 
   public static function strip_body($s,$s1,$s2=false,$offset=0, $_trim = true) {
    /*
    * http://php.net/manual/en/function.strpos.php#75146
    */

 //   if( $s2 === false ) { $s2 = $s1; }
    if( $s2 === false ) { $s2 = $s1.'--'; }
    $result = array();
    $result_2 = array();
    $L1 = strlen($s1);
    $L2 = strlen($s2);

    if( $L1==0 || $L2==0 ) {
        return false;
    }

    do {
        $pos1 = strpos($s,$s1,$offset);

        if( $pos1 !== false ) {
            $pos1 += $L1;

            $pos2 = strpos($s,$s2,$pos1);

            if( $pos2 !== false ) {
                $key_len = $pos2 - $pos1;

                $this_key = substr($s,$pos1,$key_len);
                if(true===$_trim){
					$this_key = trim($this_key);
				}

                if( !array_key_exists($this_key,$result) ) {
                    $result[$this_key] = array();
                }

                $result[$this_key][] = $pos1;
                $result_2[] = array(
                   'pos' => $pos1,
                   'content' => $this_key
                );

                $offset = $pos2 + $L2;
            } else {
                $pos1 = false;
            }
        }
    } while($pos1 !== false );

    return array(
      'pindex' => $result_2, 
      'cindex' => $result
    );
 }


    /**
     * MultiPart constructor.
     * @param string $content
     * @throws \InvalidArgumentException
     */
    protected function __construct($content, &$parent = null)
    {
    	$this->_id = ++self::$__i;
    	$this->_parent = $parent;
    	
        // Split headers and body
        $splits = preg_split('/(\r?\n){2}/', $content, 2);

        if (count($splits) < 2) {
            throw new \InvalidArgumentException("Content is not valid, can't split headers and content");
        }

        list ($headers, $body) = $splits;

        // Regroup multiline headers
        $currentHeader = '';
        $headerLines = array();
        foreach (preg_split('/\r?\n/', $headers) as $line) {
            if (empty($line)) {
                continue;
            }
            if (preg_match('/^\h+(.+)/', $line, $matches)) {
                // Multi line header
                $currentHeader .= ' '.$matches[1];
            } else {
                if (!empty($currentHeader)) {
                    $headerLines[] = $currentHeader;
                }
                $currentHeader = trim($line);
            }
        }

        if (!empty($currentHeader)) {
            $headerLines[] = $currentHeader;
        }

        // Parse headers
        $this->headers = array();
        foreach ($headerLines as $line) {
            $lineSplit = explode(':', $line, 2);
            if (2 === count($lineSplit)) {
                list($key, $value) = $lineSplit;
                // Decode value
                $value = mb_decode_mimeheader(trim($value));
            } else {
                // Bogus header
                $key = $lineSplit[0];
                $value = '';
            }
            // Case-insensitive key
            $key = strtolower($key);
            if (!isset($this->headers[$key])) {
                $this->headers[$key] = $value;
            } else {
                if (!is_array($this->headers[$key])) {
                    $this->headers[$key] = (array)$this->headers[$key];
                }
                $this->headers[$key][] = $value;
            }
        }

        // Is MultiPart ?
        $contentType = $this->getHeader('Content-Type');
        $this->contentType=$contentType;
        if ('multipart' === strstr(self::getHeaderValue($contentType), '/', true)) {
            // MultiPart !
            $this->multipart = true;
            $boundary = self::getHeaderOption($contentType, 'boundary');
            $this->boundary=$boundary;

            if (null === $boundary) {
                throw new \InvalidArgumentException("Can't find boundary in content type");
            }

            $separator = '--'.preg_quote($boundary, '/');

            if (0 === preg_match('/'.$separator.'\r?\n(.+?)\r?\n'.$separator.'--/s', $body, $matches)
              || preg_last_error() !== PREG_NO_ERROR
            ) {
              $bodyParts = self::strip_body($body,$separator."",$separator."--",0);
               if(1 !== count($bodyParts['pindex'])){
			 	 throw new \InvalidArgumentException("Can't find multi-part content");
			   }
			   $bodyStr = $bodyParts['pindex'][0]['content'];
			   unset($bodyParts);
            }else{
				$bodyStr = $matches[1];
			}


            

            $parts = preg_split('/\r?\n'.$separator.'\r?\n/', $bodyStr);
            unset($bodyStr);

            foreach ($parts as $part) {
                //$this->parts[] = new self($part, $this);
                $this->append($part);
            }
        } else {
        	
            // Decode
            $encoding = $this->getEcoding();
            switch ($encoding) {
                case 'base64':
                    $body = $this->urlsafeB64Decode($body);
                    break;
                case 'quoted-printable':
                    $body = quoted_printable_decode($body);
                    break;
            }

            // Convert to UTF-8 ( Not if binary or 7bit ( aka Ascii ) )
            if (!in_array($encoding, array('binary', '7bit'))) {
                // Charset
                $charset = self::getHeaderOption($contentType, 'charset');
                if (null === $charset) {
                    // Try to detect
                    $charset = mb_detect_encoding($body) ?: 'utf-8';
                }
                $this->charset=$charset;
            
                // Only convert if not UTF-8
                if ('utf-8' !== strtolower($charset)) {
                    $body = mb_convert_encoding($body, 'utf-8', $charset);
                }
            }

            $this->body = $body;
        }
    }


      
    public function __toString()
    {
    	$boundary = $this->getBoundary($this->isMultiPart());
    	$s='';
    	foreach($this->headers as $hname => $hvalue){
    		$s.= $this->headerName($hname).': '.  $this->getHeader($hname) /*$hvalue*/."\r\n";
		}
		
		$s.= "\r\n" ;
		if ($this->isMultiPart()) $s.=  "--" ;
		$s.= $boundary ;
		if ($this->isMultiPart()) $s.= "\r\n" ;	
		
		
		if ($this->isMultiPart()) {
            foreach ($this->parts as $part) {            	
               $s.=  (get_class($this) === get_class($part)) ? $part : $part->__toString() . "\r\n" ;
            }
             $s.= "\r\n"."--" . $boundary .  '--';
	    }else{

			$s.= $this->getBody(true, $encoding);
        }		
		
	     if (null!==$this->parent && $this->parent->isMultiPart() && $this->parent->lastChild->id !== $this->id){
            $s.= "\r\n" . "--" .$this->parent->getBoundary() . "\r\n";		
	     }
        return $s;
    }   
    
    public function getEcoding()
    {
    	$this->encoding=strtolower($this->getHeader('Content-Transfer-Encoding'));
        return $this->encoding;
    }
    
    public function getCharset()
    {
      //  return $this->charset;
       $charset = self::getHeaderOption($this->getMimeType(), 'charset');
        if(!is_string($charset)) {
          // Try to detect
          $charset = mb_detect_encoding($this->body) ?: 'utf-8';
        }
      $this->charset=$charset;
      return $this->charset;       
    }
    
     
    public function setBoundary($boundary = null, $opts = array())
    {
       	$this->mod();

    	if(null===$boundary){
 			$size = 8;
			if(4 < count($this->parts))$size = 32;
			if(6 < count($this->parts))$size = 40;
			if(8 < count($this->parts))$size = 64;
			if(10 <= count($this->parts))$size = 70;
			$opt = array(
			  'length' => $size
			);
			

			$options = array_merge($opt, $opts);
			$boundary = $this->generateBundary($options);
		}

			$this->boundary =$boundary;
			$this->setHeaderOption('Content-Type', $this->boundary, 'boundary');		
   }  
    
       
    public function getBoundary($generate = true)
    {
        $this->boundary = self::getHeaderOption($this->getHeader('Content-Type'), 'boundary');
        if(true === $generate && $this->isMultiPart() 
           && (!is_string($this->boundary) || 0===strlen(trim($this->boundary))) 
        ){
        	$this->setBoundary();
		}
        return $this->boundary;
    }   
        /** 
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function mod()
    {
       $this->modified = true;
       return $this;
    }     
    
    public function setHeader($key, $value)
    {
       $this->mod();
       $key = strtolower($key);
       $this->headers[$key]=$value;
       
		//	 echo print_r($this->headers, true);
			 
       return $this;
    }     
     
    public function removeHeader($key)
    {
       $this->mod();
       unset($this->headers[$key]);
       return $this;
    }     
       
   public function setHeaderOption($headerName, $value = null, $opt = null)
    {
       $this->mod();
    	$old_header_value = $this->getHeader($headerName);
     		 		
		
        if(null===$opt && null !==$value){
			 $this->headers[$headerName]=$value;
		}else if(null !==$opt && null !==$value){
             list($headerValue,$options) = self::parseHeaderContent($old_header_value);
             $options[$opt]=$value;
			 $new_header_value = $headerValue;
		 //	$new_header_value='';
			 foreach($options as $o => $v){
			 	$new_header_value .= ';'.$o.'='.$v.'';
			 }

			 $this->setHeader($headerName, $new_header_value);	
		} 
         

       return $this;
    }
    
              

    /**
     * @return bool
     */
    public function isMultiPart()
    {
        return $this->multipart;
    }

    /**
     * @return string
     * @throws \LogicException if is multipart
     */
    public function getBody($reEncode = false, &$encoding = null)
    {
        if ($this->isMultiPart()) {
            throw new \LogicException("MultiPart content, there aren't body");
        } else {
	    	$body = $this->body;
	    	
	     if(true===$reEncode){
            $encoding = $this->getEcoding();
            switch ($encoding) {
                case 'base64':
                    $body = $this->urlsafeB64Encode($body);
                    break;
                case 'quoted-printable':
                    $body = quoted_printable_encode($body);
                    break;
            }

            // Convert to UTF-8 ( Not if binary or 7bit ( aka Ascii ) )
            if (!in_array($encoding, array('binary', '7bit'))) {
                // back de-/encode 
                if (    'utf-8' !== strtolower(self::getHeaderOption($this->getMimeType(), 'charset'))
                     && 'utf-8' === mb_detect_encoding($body)) {
                    $body = mb_convert_encoding($body, self::getHeaderOption($this->getMimeType(), 'charset'), 'utf-8');
                }elseif (    'utf-8' === strtolower(self::getHeaderOption($this->getMimeType(), 'charset'))
                     && 'utf-8' !== mb_detect_encoding($body)) {
                    $body = mb_convert_encoding($body, 'utf-8', mb_detect_encoding($body));
                }
            }   		 	
		 }	
         
            
            return $body; 
        }
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function getHeader($key, $default = null)
    {
        // Case-insensitive key
        $key = strtolower($key);
        if (isset($this->headers[$key])) {
            return $this->headers[$key];
        } else {
            return $default;
        }
    }

    /**
     * @param string $content
     * @return array
     */
    static protected function parseHeaderContent($content)
    {
        $parts = explode(';', $content);
        $headerValue = array_shift($parts);
        $options = array();
        // Parse options
        foreach ($parts as $part) {
            if (!empty($part)) {
                $partSplit = explode('=', $part, 2);
                if (2 === count($partSplit)) {
                    list ($key, $value) = $partSplit;
                    $options[trim($key)] = trim($value, ' "');
                } else {
                    // Bogus option
                    $options[$partSplit[0]] = '';
                }
            }
        }

        return array($headerValue, $options);
    }

    /**
     * @param string $header
     * @return string
     */
    static public function getHeaderValue($header)
    {
        list($value) = self::parseHeaderContent($header);

        return $value;
    }

    /**
     * @param string $header
     * @return string
     */
    static public function getHeaderOptions($header)
    {
        list(,$options) = self::parseHeaderContent($header);

        return $options;
    }

    /**
     * @param string $header
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    static public function getHeaderOption($header, $key, $default = null)
    {
        $options = self::getHeaderOptions($header);

        if (isset($options[$key])) {
            return $options[$key];
        } else {
            return $default;
        }
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        // Find Content-Disposition
        $contentType = $this->getHeader('Content-Type');

        return self::getHeaderValue($contentType) ?: 'application/octet-stream';
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        // Find Content-Disposition
        $contentDisposition = $this->getHeader('Content-Disposition');

        return self::getHeaderOption($contentDisposition, 'name');
    }

    /**
     * @return string|null
     */
    public function getFileName()
    {
        // Find Content-Disposition
        $contentDisposition = $this->getHeader('Content-Disposition');

        return self::getHeaderOption($contentDisposition, 'filename');
    }

    /**
     * @return bool
     */
    public function isFile()
    {
        return !is_null($this->getFileName());
    }

    /**
     * @return Part[]
     * @throws \LogicException if is not multipart
     */
    public function getParts()
    {
        if ($this->isMultiPart()) {
            return $this->parts;
        } else {
            throw new \LogicException("Not MultiPart content, there aren't any parts");
        }
    }

    /**
     * @param string $name
     * @return Part[]
     * @throws \LogicException if is not multipart
     */
    public function getPartsByName($name)
    {
        $parts = array();

        foreach ($this->getParts() as $part) {
            if ($part->getName() === $name) {
                $parts[] = $part;
            }
        }

        return $parts;
    }
}





__halt_compiler();Mime-Version: 1.0
Content-Type: multipart/mixed;boundary=hoHoBundary12344dh
To: example@example.com
From: script@example.com

--hoHoBundary12344dh
Content-Type: multipart/alternate;boundary=EVGuDPPT

--EVGuDPPT
Content-Type: text/html;charset=utf-8

<h1>InstallShield</h1>
<p>Your Installer you downloaded at <a href="http://www.webfan.de/install/">Webfan</a> is attatched in this message.</p>
<p>You may have to run it in your APC-Environment.</p>


--EVGuDPPT
Content-Type: text/plain;charset=utf-8

 -InstallShield-
Your Installer you downloaded at http://www.webfan.de/install/ is attatched in this message.
You may have to run it in your APC-Environment.

--EVGuDPPT
Content-Type: multipart/related;boundary=4444EVGuDPPT
Content-Disposition: php ;filename="$__FILE__/stub.zip";name="archive stub.zip"

--4444EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$STUB/bootstrap.php";name="stub bootstrap.php"

<?php

spl_autoload_register(array($this,'Autoload'), true, true);


\frdl\webfan\Autoloading\SourceLoader::repository('frdl'); 

\frdl\webfan\App::God(true, 'frdl\webfan\Autoloading\Autoloader','AC boot') 

;




--4444EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$HOME/index.php";name="stub index.php"
Content-Md5: 52405ceb715f7cf8344150c321d8df31
Content-Sha1: cc25eb33901fb30014eeaa057f8d8ce63c5e6a9f
Content-Length: 2611

<?php

 $vm = &$this;




 
 $htmls = array();
 $htmls_state = array();
 
		


 
		\frdl\webfan\App::God(false)->addFunc('apcOut', (function($html = null) use(&$vm, &$htmls, &$htmls_state) {
			
			$tpl = $vm->get_file($vm->document, '$__FILE__/templates/index.html', 'templates index.html');
			
			
			if(is_string($html)){
				array_push($htmls, $html);
			}			
			
			$vm->context->html_contents = $htmls;
			$vm->context->html_contents_state = $htmls_state;
			
			$vm->_run_php_1($tpl);
			
				//echo $html;
	        die();
		}));


		\frdl\webfan\App::God(false)->addFunc('apcHTML', (function($html) use(&$vm, &$htmls) {
			if(is_string($html)){
				array_push($htmls, $html);
			}			
		}));		
		


		\frdl\webfan\App::God(false)->addFunc('apcDestMessage', (function($html, $dest = '') use(&$vm, &$htmls_state) {
			if(is_string($html)){
				$html = '<div frdl-mod-dest="'.$dest.'">'.$html.'</div>';
				array_push($htmls_state, $html);
			}			
		}));
				

		\frdl\webfan\App::God(false)->addFunc('apcStateMessage', (function($html, $state = 'apc') use(&$vm, &$htmls_state) {
			if(is_string($html)){
				$html = '<div frdl-mod="serverToState '.$state.'">'.$html.'</div>';
				array_push($htmls_state, $html);
			}			
		}));
		
				

		\frdl\webfan\App::God(false)->addFunc('apcWarn', (function($html) use(&$vm, &$htmls) {
			if(is_string($html)){
				array_push($htmls, '<p style="color:red;">'.$html.'</p>');
			}			
		}));				
		
		
		\frdl\webfan\App::God(false)->addFunc('apcLoginform', (function() use(&$vm) {
				$html = '<div>';
				$html .= '<legend>Login to your APC php backend</legend>';
				 $html .= '<form action="'.\frdl\webfan\App::God(false)->apc_api_client_url().'" method="post">';
				  $html .= '<p><legend>User/PIN</legend>
<input type="password" name="PIN" /></p>';

$html .= '<p><legend>Password</legend>
<input type="password" name="password" /></p>';
				 $html .= '<p><input type="submit" name="login" value="login" /></p>';
				 $html .= '</form>';
				$html .= '</div>';
				
				return $html;		
		}));	
	
	
	
	
		
					
 


\frdl\webfan\App::God(false)->addFunc('session', (function() use(&$vm){
 	if(!isset($_SESSION['apc']))$_SESSION['apc']=array();
    $args = func_get_args();
    if(0===count($args, COUNT_NORMAL))return $_SESSION['apc'];
    if(1===count($args, COUNT_NORMAL)){
    	if(!isset($_SESSION['apc'][$args[0]]))return null;
		return $_SESSION['apc'][$args[0]];
	}elseif(2===count($args, COUNT_NORMAL)){
		$_SESSION['apc'][$args[0]] = $args[1];
	}
	
}));	
--4444EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$HOME/detect.php";name="stub detect.php"
<?php: 


	 $vm = &$this;
		
		\frdl\webfan\App::God(false)->addFunc('getOSName', (function(){
			return  PHP_OS;
		}));
		 
		
		\frdl\webfan\App::God(false)->addFunc('getServerIp',(function ($all = true){
		                       $i = gethostbynamel($_SERVER['SERVER_NAME']);
		                       if($all === false)return ((isset($i['ips'][0])) ? $i['ips'][0] : '0.0.0.0');
							   return $i;
	                    }));
		
		\frdl\webfan\App::God(false)->addFunc('getBaseDir',(function (){
		                         $open_basedir = ini_get('open_basedir');
		                         if(!is_string($open_basedir) || trim($open_basedir) === ''){
	    	                     return realpath($_SERVER['DOCUMENT_ROOT'].\frdl\webfan\App::DS.'..'.\frdl\webfan\App::DS).\frdl\webfan\App::DS;
		               }else{
		                     	 $basedir = explode(':', $open_basedir);
			                     $basedir = trim($basedir[0]);
			                     return $basedir;
		                    }	
	                    }));
	                    
\frdl\webfan\App::God(false)->addFunc('apc_api_client_url', (function() use(&$vm) {
 if(!isset($_SERVER['REQUEST_SCHEME'])){
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';	
 }else{
  $protocol =	$_SERVER['REQUEST_SCHEME'];
 }


 if(!isset($_SERVER['SERVER_NAME']) || '_' === $_SERVER['SERVER_NAME'] || '' === $_SERVER['SERVER_NAME'] || ' ' === $_SERVER['SERVER_NAME']){
	$server = $_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'];
 }else{
	$server = $_SERVER['SERVER_NAME'];
 }

 $_p = explode('?', $_SERVER['REQUEST_URI']);
return $protocol.'://'.$server.$_p[0];
}));	                    
	                    



\frdl\webfan\App::God(false)->addFunc('apc_manifest_url', (function() use(&$vm) {
 return \frdl\webfan\App::God(false)->apc_api_client_url().'?web=manifest.webapp';
}));	                    
	                    
\frdl\webfan\App::God(false)->addFunc('apc_favicon_url', (function() use(&$vm) {
 return \frdl\webfan\App::God(false)->apc_api_client_url().'?web='.urlencode('/images/apc.ico');
}));	                    
	  




		\frdl\webfan\App::God(false)->addFunc('apcIsWritableStubFile', (function() use(&$vm) {
				return is_writable($vm->__FILE__);
		}));
   
   
 \frdl\webfan\App::God(false)->addFunc('apcChmodStubFile', (function($chmod) use(&$vm) {
 
    //  try{
    //	@chmod(dirname($vm->__FILE__), $chmod);
   //  }catch(\Exception $e){
    //	\frdl\webfan\App::God(false)->apcWarn($e->getMessage());
   // }
 	
     try{
    	@chmod($vm->__FILE__, $chmod);
     }catch(\Exception $e){
    	\frdl\webfan\App::God(false)->apcWarn($e->getMessage());
     }
     
     //$p = (string)substr(sprintf('%o', fileperms($vm->__FILE__)), -4);
     //if('0777' !== $p && '0775' !== $p){
     if(!is_writable($vm->__FILE__)){	
	 	\frdl\webfan\App::God(false)->apcWarn('Cannot set stub to writable!');
	 }
     	
     	
 if(0<count($vm->Context->apc->config->admin, COUNT_NORMAL) && true===$vm->context->apc->config->config_source['install']){
	if(!is_dir($vm->context->apc->config->config_source['dir_lib'])){
		try{
			@mkdir($vm->context->apc->config->config_source['dir_lib'],0755, true);
		}catch(\Exception $e){
			if(\frdl\webfan\App::God(false)->apcIsAdmin())\frdl\webfan\App::God(false)->apcWarn($e->getMessage());
		}
	}else{
		
	}
	
		try{
			if(is_dir($vm->context->apc->config->config_source['dir_lib']))@chmod($vm->context->apc->config->config_source['dir_lib'],0755);
		}catch(\Exception $e){
			if(\frdl\webfan\App::God(false)->apcIsAdmin())\frdl\webfan\App::God(false)->apcWarn($e->getMessage());
		}
			
  if(is_writable($vm->context->apc->config->config_source['dir_lib']))	{
	\frdl\webfan\Autoloading\SourceLoader::top()
	   ->config_source('install', true);
	   
	\frdl\webfan\Autoloading\SourceLoader::top()   
	   ->config_source('dir_lib', $vm->context->apc->config->config_source['dir_lib']);
	   
	\frdl\webfan\Autoloading\SourceLoader::top()   
	   ->addPsr4('\\', $vm->context->apc->config->config_source['dir_lib'], false) 
	;  	
  }



 }  	
     			
     			
     			
    return $vm;
}));   


		\frdl\webfan\App::God(false)->addFunc('vm', (function() use(&$vm) {
	         return $vm;
		}));
		
		
		\frdl\webfan\App::God(false)->addFunc('apcIsAdmin', (function() use(&$vm) {
             $us = \frdl\webfan\App::God(false)->session('user');
           
             if(null===$us || !is_array($us))return false;
	         return (in_array('admin', $us['permissions']) ) ? true : false;
		}));
		
		
		
--4444EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$HOME/apc_config.php";name="stub apc_config.php"
<?php: 


$this->Context->apc = new \O;

$this->Context->apc->config = new \O;
$this->Context->apc->config->admin = array();

$this->Context->apc->config->config_source = array( 
	 'install' =>  true,
     'dir_lib' => __DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR . 'apc' . DIRECTORY_SEPARATOR . 'dir_lib' . DIRECTORY_SEPARATOR,
     'session' => false,
     'zip_stream' => false,
     'append_eval_to_file' => false,
     
      'dir_apc' =>  __DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR . 'apc' . DIRECTORY_SEPARATOR. 'apc-apc' . DIRECTORY_SEPARATOR,
     
     'dir_packages' =>  __DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR . 'apc' . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR,
     'dir_Psr4' =>  __DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR . 'apc' . DIRECTORY_SEPARATOR . 'Psr4' . DIRECTORY_SEPARATOR,
     'dir_Psr0' =>  __DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR . 'apc' . DIRECTORY_SEPARATOR . 'Psr0' . DIRECTORY_SEPARATOR,  
     
     'dir_web' =>  __DIR__ . DIRECTORY_SEPARATOR,         
     
     'dir_projects' =>  __DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR . 'apc' . DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR,  
    'dir_apc_bootstrap' =>  __DIR__ . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR . 'apc' . DIRECTORY_SEPARATOR . 'apc-bootstrap' . DIRECTORY_SEPARATOR,  
           
);
$this->Context->apc->config->data=array (
  'PACKAGE' => 'frdl/webfan',
  'VERSION' => '1.2.0.0.1487610230.4776',
  'OID' => '1.3.6.1.4.1.37553.8.1.8.8.5.65',
  'DOWNLOADTIME' => 1487610230,
  'INSTALLTIME' => false,
  'PIN_I' => false,
  'UID' => 0,
  'UNAME' => '@anonymous',
  'EMAIL' => false,
  'REGISTERED' => false,
  'LICENSEKEY' => false,
  'LICENSESERIAL' => false,
  'SECRET' => 'Et${gq:)YP+J?.2)jK{9C|Ae_dn3A}:xIJi(u.^<:yBbtiN%U?g7Wb%nU[:nAWc{o|38?X|CHvyRv[&B/F+6Du!k>9hcI5:a;|q/EV$}?3W?<Qr|&`LBL/tHcD^b;Y[QTgq9?jL]DO[v7<eMs%JgnsH8Zgmt.i.JRtDZ~BDTNwd<b`dh6-H04J_y9JoiwHPmwr4Cw_0O!<C1afka%XTxol%gI|AEd2ciP9L&_IK=zm]dKzQ?=!+Lxt$(0<jz.VT3',
  'SHAREDSECRET' => false,
  'SHAREDSECRET_apc_1_2_0' => 'sy(?j.x{w-BvB^zXZCZc=M.>`_EK!=ptz[vTeR!{HLXiDLJs[)r6m+j_/yH;Nqf.[>ty,d<U&~h},.LHWFe}t%snGzQ^4dZz==?)M1_Cu40LnQD~b1v<Q<KuVUqy}gfi]ShBGg}{qt6VHo848%OluHO+T,&}mJt;jhs,MQAUA{HVT/!4kflkL0;JY=hoW>9y$JLf^M43He(dA({*`ki.hZ-uH*a57l,Z]r?d64o2-SEZ[f1G7Y$wLc_Hdc_MmO9I',
  'KEY_RANDOM_apc_1_2_0' => 'Z~!l7g:n-JV4tIn>D86]Y~k)*C1!zpZYIyblUXW$zB$!*.lb?Ja.5C.?Rdh.9K%^EkAWF2PhG^-qtKcH(+AYXI?MSs&Kg6}<:~dmVQHJiYp|r/~2FX:Y2<7;^;gLzs-oo7{Clmb3.UvYL]LN(qt-F,B)01x1!/LRIDz4Mc.<MH[z7x:gB;L]}|9~jq%Q,sQ9(iWvZ6(yf8m_ifKb=C=tSGhh9H4EqZp43]rp~;y5!$fN(myoBz3BhjsGbf,TnIC)',
  'KEY_COMPUTED_apc_1_2_0' => 'e05931682002d9d38c37782ccc4dca18b85a89df',
);$this->Context->apc->config->version_installer="1.2.0.0.1487610230.4776";
--4444EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$HOME/apc_install.php";name="stub apc_install.php"


<?php

 $vm = &$this;



\frdl\webfan\App::God(false)->apcChmodStubFile(0755);

if(!\frdl\webfan\App::God(false)->apcIsWritableStubFile()){
	$warning = 'The Installer File is not writable!';
	\frdl\webfan\App::God(false)->apcWarn($warning);
	/* trigger_error($warning, E_USER_WARNING); */
}
/*
\frdl\webfan\App::God(false)->apcWarn('The Installer is currently updated, please download it later again! <a href="http://www.webfan.de/install/">http://www.webfan.de/install/</a>');

*/

//\frdl\webfan\App::God(false)->apcStateMessage('The Installer is currently updated, please download it later again! <a href="http://www.webfan.de/install/">http://www.webfan.de/install/</a>', 'apc.install');

if(!session_start()){
     	\frdl\webfan\App::God(false)->apcWarn('Cannot start sesssion!');
}		



 	/*
 	
 	  public function config_source($key = null, $value = null){
  	   if(!is_string($key))return self::$config_source;
	   if(!isset(self::$config_source[$key]))return false;
	   self::$config_source[$key] = $value;
	   return true;
  }  
	 
 	*/
if(0<count($this->Context->apc->config->admin, COUNT_NORMAL)
 && true === $vm->context->apc->config->config_source['install'] 
 && is_dir($vm->context->apc->config->config_source['dir_lib'])
 && is_writable($vm->context->apc->config->config_source['dir_lib'])
){
	  \frdl\webfan\Autoloading\SourceLoader::top()
          ->config_source('install', (bool)$vm->context->apc->config->config_source['install']);   
   
   	  \frdl\webfan\Autoloading\SourceLoader::top()
          ->config_source('dir_lib', $vm->context->apc->config->config_source['dir_lib']);   
}
 	


$apcBoottrapDir = $vm->context->apc->config->config_source['dir_apc'].'webfan-master'.DIRECTORY_SEPARATOR.'.ApplicationComposer'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR;
if(is_dir($apcBoottrapDir)){
 call_user_func_array(function($d){

  \frdl\webfan\Autoloading\SourceLoader::top()
       ->addPsr4('\\', $d, true)  
       ->addPsr4('frdl\\', $d.'frdl'.DIRECTORY_SEPARATOR, true)  
   ;   

 }, array($apcBoottrapDir));	

}


if(isset($this->Request->request['cmd']) && \frdl\webfan\App::God(false)->apcIsAdmin()){
  $Console = new \webfan\InstallShield\apc\cmd1($this);	
  $Console->exe($this->Request->request['cmd']);  
  die();
}elseif(isset($this->Request->request['cmd']) && !\frdl\webfan\App::God(false)->apcIsAdmin()){
  \webdof\wResponse::status(401);	
  die('You are not logged in');
}	


if('POST' === $_SERVER['REQUEST_METHOD'] || 'PUT' === $_SERVER['REQUEST_METHOD']){
	$mFile = $vm->get_file($vm->document, '$HOME/method.post.php', 'apc method.post.php');
	if(false !== $mFile){
		$vm->_run_php_1($mFile);
	}else{
		\frdl\webfan\App::God(false)->apcWarn('Cannot find stub#file: '.'apc method.post.php');
	}
}



if(!\frdl\webfan\App::God(false)->apcIsAdmin()){

if(0===count($this->Context->apc->config->admin, COUNT_NORMAL)){
	
	$noadminHint = 'No Admin installed! Go <a ui-sref="apc.install({ })" ui-sref-opts="{reload: false}">Config->Install</a> to secure your installer script!';
 \frdl\webfan\App::God(false)->apcWarn($noadminHint); 	
	 \frdl\webfan\App::God(false)->apcDestMessage( 
		 $noadminHint
	  , 'apc.projects.project apc 1.2.x');	
			
	
				$__html = '<div>';
				$__html .= '<h1 style="color:red;">Install an Admin for your APC php backend</h1>';
				 $__html .= '<form action="'.\frdl\webfan\App::God(false)->apc_api_client_url().'#/apc/install/" method="post">';
				  $__html .= '<p><legend>User/PIN</legend>
<input type="text" name="PIN" /></p>';

$__html .= '<p><legend>Password</legend>
<input type="password" name="password" /></p>';

$__html .= '<p><legend>Confirm password</legend>
<input type="password" name="password_confirm" /></p>';

 $__html .= '<input type="hidden" name="install_op" value="apc.admin" />';

				 $__html .= '<p><input type="submit" name="install" value="install" style="color:red;font-size:1.4em;" /></p>';
				 $__html .= '</form>';
				$__html .= '</div>';
					
	
  \frdl\webfan\App::God(false)->apcStateMessage($__html, 'apc.install');
  
 unset($__html); 	
}else{
	
 // \frdl\webfan\App::God(false)->apcHTML( \frdl\webfan\App::God(false)->apcLoginform()	);	
 \frdl\webfan\App::God(false)->apcDestMessage( \frdl\webfan\App::God(false)->apcLoginform(), 'apc.projects.project apc 1.2.x');
 
 	 \frdl\webfan\App::God(false)->apcDestMessage(\frdl\webfan\App::God(false)->apcLoginform(), 'apc.config serverHtml');		

  
 unset($__html); 
}


}else{
	
	$_htmClassCache = '';
	
	$_htmClassCache.='<div>';
	$_htmClassCache.='<legend>';
	 $_htmClassCache.='<strong>Class Cache</strong>';
	$_htmClassCache.='</legend>';
	  $_htmClassCache .= '<form action="'.\frdl\webfan\App::God(false)->apc_api_client_url().'#/apc/config/" method="post">';


//<input type="password" name="config_source__install" value="'.$vm->context->apc->config_source['install'].'" />

$__checked = (false === $vm->context->apc->config->config_source['install']) ? ' ' : ' checked ';

$_htmClassCache .= '<p><legend>InstallShield cache classes (for InstallShield)</legend>

<input type="checkbox" name="config_source__install" '.$__checked.' />
</p>

';


$readonly = (is_dir($vm->context->apc->config->config_source['dir_lib'])) ? ' readonly ' : ' ';
$_htmClassCache .= '<p><legend>Class Cache Directory (for InstallShield)</legend>
<input '.$readonly.' type="text" name="config_source__dir_lib"  value="'.$vm->context->apc->config->config_source['dir_lib'].'" /></p>';
	  

$readonly = (is_dir($vm->context->apc->config->config_source['dir_apc'])) ? ' readonly ' : ' ';	  
$_htmClassCache .= '<p><legend>APC (InstallShield) Directory</legend>
<input  '.$readonly.' type="text" name="dir_apc"  value="'.$vm->context->apc->config->config_source['dir_apc'].'" /></p>';
	  
	  
	  
$readonly = (is_dir($vm->context->apc->config->config_source['dir_projects'])) ? ' readonly ' : ' ';	  
$_htmClassCache .= '<p><legend>Projects Directory</legend>
<input  '.$readonly.' type="text" name="dir_projects"  value="'.$vm->context->apc->config->config_source['dir_projects'].'" /></p>';
	  
	  	  
$readonly = (is_dir($vm->context->apc->config->config_source['dir_apc_bootstrap'])) ? ' readonly ' : ' ';	  
$_htmClassCache .= '<p><legend>Bootstrap Stub Directory</legend>
<input '.$readonly.'  type="text" name="dir_apc_bootstrap"  value="'.$vm->context->apc->config->config_source['dir_apc_bootstrap'].'" /></p>';
	  
	  
	  
	  
$readonly = (is_dir($vm->context->apc->config->config_source['dir_web'])) ? ' readonly ' : ' ';
$_htmClassCache .= '<p><legend>Web-Directory</legend>
<input  '.$readonly.' type="text" name="dir_web" value="'.$vm->context->apc->config->config_source['dir_web'].'" />
</p>
';

$readonly = (is_dir($vm->context->apc->config->config_source['dir_packages'])) ? ' readonly ' : ' ';
$_htmClassCache .= '<p><legend>Packages-Directory</legend>
<input  '.$readonly.' type="text" name="dir_packages"  value="'.$vm->context->apc->config->config_source['dir_packages'].'" /></p>';
	  
$readonly = (is_dir($vm->context->apc->config->config_source['dir_Psr4'])) ? ' readonly ' : ' ';	  
$_htmClassCache.='<div>';	  	  
$_htmClassCache.='<h2>Autoloading-Directories</h2>';	  
$_htmClassCache .= '<p><legend>Psr-4 Directory</legend>
<input '.$readonly.'  type="text" name="dir_Psr4" value="'.$vm->context->apc->config->config_source['dir_Psr4'].'" />
</p>
';

$readonly = (is_dir($vm->context->apc->config->config_source['dir_Psr0'])) ? ' readonly ' : ' ';
$_htmClassCache .= '<p><legend>Psr-0 Directory</legend>
<input '.$readonly.'  type="text" name="dir_Psr0" value="'.$vm->context->apc->config->config_source['dir_Psr0'].'" />
</p>
';
$_htmClassCache.='</div>';


$_htmClassCache.= '<p><input type="submit" name="config_dirs" value="Change directories (be carefull!)" style="font-size:1.4em;" /></p>';
	  
	  $_htmClassCache .= '</form>';
	
	$_htmClassCache.='</div>';
	
	 \frdl\webfan\App::God(false)->apcDestMessage($_htmClassCache, 'apc.config serverHtml');	
	 
	 
	
	        	$__html = '<div class="frdlWebfanContentBoxWithBorder">';
				$__html .= '<p>Your <a ui-sref="apc.config({ })" ui-sref-opts="{reload: false}">APC backend</a> <strong>InstallShield</strong> version '.$this->Context->apc->config->data['VERSION'].' is already present.</p>';
				$__html .= '<p>Update Sytem... @ToDo (coming soon)</p>'; 
			 /*   $__html .= '<p>version '.$this->Context->apc->config->data['VERSION'].'</p>'; 
			 
			    $__html .= '<p>'.$_htmClassCache.'</p>'; */
			 
				$__html .= '</div>';
					
	
 // \frdl\webfan\App::God(false)->apcStateMessage($__html, 'apc.install');
 \frdl\webfan\App::God(false)->apcDestMessage($__html, 'apc.install serverHtml');	
   unset($__html, $_htmClassCache);
  
	\frdl\webfan\App::God(false)->apcHTML( \frdl\apc\Helper::adminMenu_1()	);
}



/* <p><pre>'.print_r($this->Context, true).'</pre></p>
\frdl\webfan\App::God(false)->apcStateMessage('<div>
<strong>test:</strong>
<p><pre>'.print_r($_SERVER, true).'</pre></p>

</div>',

'apc.config'
);

 */



$webFilesKey = 'web';
if(isset($_GET[$webFilesKey])){
	$webPath = strip_tags($_GET[$webFilesKey]);
	$webFile = $vm->get_file($vm->document, '$HOME/$WEB'.$webPath, '$WEB '.$webPath);
	if(false !== $webFile){
		if('application/x-httpd-php' === $webFile->getMimeType()){
		   $vm->_run_php_1($webFile);
		   die();
		}else{
			header_remove();
			header('Content-Type: '.$webFile->getHeader('Content-Type'));
			die(trim($webFile->getBody()));
		}
		
	}else{
		\webdof\wResponse::status(404);
		\frdl\webfan\App::God(false)->apcWarn('404 - not found for '.$webPath);
	}	
}

\frdl\webfan\App::God(false)->apcOut();
--4444EVGuDPPT--
--EVGuDPPT--
--hoHoBundary12344dh
Content-Type: multipart/related;boundary=3333EVGuDPPT
Content-Disposition: php ;filename="$__FILE__/attach.zip";name="archive attach.zip"

--3333EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$DIR_PSR4/O.php";name="class O"

<?php
 /**
 * Compression Shortcut
 */
class O extends \stdclass{}





--3333EVGuDPPT
Content-Type: multipart/serial;boundary=2222EVGuDPPT
Content-Disposition: php ;name="dir $DIR_PSR4"

--2222EVGuDPPT
Content-Type: application/vnd.frdl.script.php;charset=utf-8
Content-Disposition: php ;filename="$DIR_LIB/frdl/A.php";name="class frdl\A"

<?php
/**
 * Copyright  (c) 2015, Till Wehowski
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 *    must display the following acknowledgement:
 *    This product includes software developed by the frdl/webfan.
 * 4. Neither the name of frdl/webfan nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY frdl/webfan ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL frdl/webfan BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * 
 *  @component abstract frdl\A
 * 
 */
 namespace frdl;
 
 abstract class A{
 	
  const FN_ASPECTS = 'aspects';	
     /**
    *  default $SEMRÂ´s
	*  const  SERVER_ROUTER = {$cmd=SERVER} . {$format} . {$modul} . {$outputbuffers = explode(',')} 
	*/
	const TPL_SERVER_ROUTE = '{$cmd}.{$responseformat}.{$modul}.{$responsebuffers}';
    const SERVER_PAGE = 'SERVER.html.PAGE.buffered';
    const SERVER_HTML = 'SERVER.html.HTML.buffered';
    const SERVER_API = 'SERVER.?.API.format';
    const SERVER_404 = 'SERVER.html.404.buffered';
    const SERVER_JS = 'SERVER.js.JS.compressed,pragma';
    const SERVER_CSS = 'SERVER.css.CSS.compressed,pragma';
    const SERVER_IMG = 'SERVER.img.IMG.compressed,pragma';
	
    const SERVER_DEFAULT = self::SERVER_PAGE;
    	
  protected $ns_pfx = array('?' => array('frdl' => true),
              '$'=> array('frdl' => true), 
              '$'=> array('frdl' => true),
              '!'=> array('frdl' => true), 
              '#'=> array('frdl' => true), 
              '-'=> array('frdl' => true),
              '.'=> array('frdl' => true), 
              '+'=> array('frdl' => false), 
              ',' => array('frdl' => true)
          );	
  protected $wrappers;
  protected $shortcuts;
 	
  
 
  public function addShortCut ($short,  $long, $label = null){

		 
  	 array_walk($this->ns_pfx,function(&$v){
  	 	  if(!isset($v[\frdl\A::FN_ASPECTS])) $v[\frdl\A::FN_ASPECTS] = array(); 	 	
  	 });
  	 
  	    $ns = substr($short, 0, 1);
  	     if(!is_array($this->shortcuts))$this->shortcuts = array();
        $this->shortcuts[$short] = $long;
          
          if(isset($this->ns_pfx[$ns])){
		  	 if(!isset($this->ns_pfx[$ns][self::FN_ASPECTS]) || !is_array($this->ns_pfx[$ns][self::FN_ASPECTS])) $this->ns_pfx[$ns][self::FN_ASPECTS] = array(); 	
		  	 $aspect = array(
		  	   'label' => (is_string($label)) ? $label : $short,
		  	   'short' => $short,
		  	   'long' => $long
		  	 );
		  	$this->ns_pfx[$ns][self::FN_ASPECTS][$short] = $aspect;
		  }
		  
		 return $this;
  } 
	 
	
 /**
 * todo...
 * 
 */	
  protected function apply_fm_flow(){
  	 $args  = func_get_args();
     $THIS = &$this;
     $SELF = &$this;
         	
   \webfan\App::God() 	
      -> {'$'}('?session_started', (function($startIf = true) use ($THIS, $SELF) {
       	$r = false; 
        if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            $r =  session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
          } else {
             $r =  '' === session_id()  ? FALSE : TRUE;
          }
        }
        
        if(true === $startIf && false === $r){
          if(!session_start()){	
            if(isset($THIS) && isset($THIS->debug) && true === $THIS->debug) trigger_error('Cannot start session in '.basename(__FILE__).' '.__LINE__, E_USER_WARNING);
          }
		}
        
        
       return $r ;
        }) );
     

     $func_jsonP = (function($str) use ($THIS, $SELF) {
		 		       	 $r = (isset($THIS) && isset($THIS->data['data_out'])) ? $THIS->data['data_out'] : new \stdclass;
		 		       	 $r->type = 'print';
		 		       	 $r->out = $str;
      	                 $fnregex = "/^[A-Za-z0-9\$\.-_\({1}\){1}]+$/";
      	                 $callback = (isset($_REQUEST['callback']) && preg_match($fnregex, $_REQUEST['callback']))
		                   ? strip_tags($_REQUEST['callback'])
		                   : '';
		                   
		                   
                if($callback === ''){
         	            $o = json_encode($r);
                }  else {
                	       $r->callback = $callback;
                           $o = $callback.'(' . json_encode($r) . ')';
		                }
		                
		        return $o;
		 	});
		 	
		 	
   /**
   * http://php.net/manual/en/function.apache-request-headers.php#116645
   */      	
   \webfan\App::God() 	
      -> {'$'}('?request_headers', function() {
      	     if( function_exists('apache_request_headers') )return apache_request_headers();
                  foreach($_SERVER as $K=>$V){$a=explode('_' ,$K);
                        if(array_shift($a)==='HTTP'){
                           array_walk($a,function(&$v){$v=ucfirst(strtolower($v));});
                           $retval[join('-',$a)]=$V;}
                  } 
             return $retval;
          }
      );
        	
        	
	     \webfan\App::God() 
            -> {'$'}('$.sem.parse', function($sem) use ($THIS, $SELF) {
            	    $str = $SELF::TPL_SERVER_ROUTE;
            	    foreach($sem as $k => $v){
						$s = (is_array($v)) ? implode(',', $v) : $v;
						$str = str_replace('{$'.$k.'}', $s, $str);
					}
            	    return $str;
            	})
            	// '{$cmd}.{$responseformat}.{$modul}.{$responsebuffers}'; 	
            -> {'$'}('$.sem.unparse', function(&$sem, $route) use ($THIS, $SELF) {
            	    $seg = explode('.', $route);
            	    $sem['cmd'] =  array_shift($seg);
            	    $sem['responseformat'] =  array_shift($seg);
            	    $sem['modul'] =   array_shift($seg);
            	    $sem['responsebuffers'] = explode(',',array_shift($seg));
            	    $sem['.nodes'] =$seg;
                    return $THIS;
            	})
            	
            	
            -> {'$'}('$.sem->getFomatterMethod', (function($format){
            	 if('jsonp' !== $format && 'json' !== $format)return false;
                     return '$.sem.format->'.$format;
            	}))	
            -> {'$'}('$.sem.format->json', $func_jsonP )
            -> {'$'}('$.sem.format->jsonp', $func_jsonP)  
            /**
			* todo   css,txt,php,bin,dat,js,img,....
			*/
            -> {'$'}('$.sem.get->mime', (function($format = null, $file = null, $apply = true, $default = '') use ($THIS, $SELF) {
            $file = ((null===$file || !is_string($file)) ? \webdof\wURI::getInstance()->getU()->file : $file); 	
            if(true === $apply)$THIS->format = $default;
            
   	        $mime_types = array(
            '' =>array( 'text/html',),
            'frdl' =>array( 'application/frdl-bin',),
            'jpg' => array('image/jpeg', ),
            'jpeg' => array('image/jpeg',),
            'jpe' => array('image/jpeg',),
            'gif' => array('image/gif',),
            'png' => array('image/png',),
            'bmp' =>array( 'image/bmp',),
            'flv' => array('video/x-flv',),
            'js' => array('application/x-javascript',),
            'json' =>array( 'application/json',),
            'jsonp' =>array( 'application/x-javascript',),
            'tiff' => array('image/tiff',),
            'css' =>array( 'text/css',),
            'xml' => array('application/xml',),
            'doc' => array('application/msword',),
            'docx' => array('application/msword',),
            'xls' =>array( 'application/vnd.ms-excel',),
            'xlm' => array('application/vnd.ms-excel',),
            'xld' => array('application/vnd.ms-excel',),
            'xla' => array('application/vnd.ms-excel',),
            'xlc' => array('application/vnd.ms-excel',),
            'xlw' => array('application/vnd.ms-excel',),
            'xll' => array('application/vnd.ms-excel',),
            'ppt' => array('application/vnd.ms-powerpoint',),
            'pps' => array('application/vnd.ms-powerpoint',),
            'rtf' => array('application/rtf',),
            'pdf' => array('application/pdf',),
            'html' =>array( 'text/html',),
            'htm' => array('text/html',),
            'php' => array('text/html',),
            'txt' => array('text/plain',),
            'mpeg' => array('video/mpeg',),
            'mpg' => array('video/mpeg',),
            'mpe' => array('video/mpeg',),
            'mp3' =>array( 'audio/mpeg3',),
            'wav' => array('audio/wav',),
            'aiff' =>array('audio/aiff',),
            'aif' =>array( 'audio/aiff',),
            'avi' => array('video/msvideo',),
            'wmv' => array('video/x-ms-wmv',),
            'mov' => array('video/quicktime',),
            'zip' =>array( 'application/zip',),
            'tar' => array('application/x-tar',),
            'swf' => array('application/x-shockwave-flash',),
            'odt' => array('application/vnd.oasis.opendocument.text',),
            'ott' => array('application/vnd.oasis.opendocument.text-template',),
            'oth' =>array( 'application/vnd.oasis.opendocument.text-web',),
            'odm' => array('application/vnd.oasis.opendocument.text-master',),
            'odg' => array('application/vnd.oasis.opendocument.graphics',),
            'otg' => array('application/vnd.oasis.opendocument.graphics-template',),
            'odp' =>array( 'application/vnd.oasis.opendocument.presentation',),
            'otp' => array('application/vnd.oasis.opendocument.presentation-template',),
            'ods' => array('application/vnd.oasis.opendocument.spreadsheet',),
            'ots' => array('application/vnd.oasis.opendocument.spreadsheet-template',),
            'odc' => array('application/vnd.oasis.opendocument.chart',),
            'odf' => array('application/vnd.oasis.opendocument.formula',),
            'odb' => array('application/vnd.oasis.opendocument.database',),
            'odi' => array('application/vnd.oasis.opendocument.image',),
            'oxt' => array('application/vnd.openofficeorg.extension',),
            'docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document',),
            'docm' => array('application/vnd.ms-word.document.macroEnabled.12',),
            'dotx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.template',),
            'dotm' => array('application/vnd.ms-word.template.macroEnabled.12',),
            'xlsx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',),
            'xlsm' => array('application/vnd.ms-excel.sheet.macroEnabled.12',),
            'xltx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.template',),
            'xltm' => array('application/vnd.ms-excel.template.macroEnabled.12',),
            'xlsb' => array('application/vnd.ms-excel.sheet.binary.macroEnabled.12',),
            'xlam' => array('application/vnd.ms-excel.addin.macroEnabled.12',),
            'pptx' => array('application/vnd.openxmlformats-officedocument.presentationml.presentation',),
            'pptm' => array('application/vnd.ms-powerpoint.presentation.macroEnabled.12',),
            'ppsx' =>array( 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',),
            'ppsm' => array('application/vnd.ms-powerpoint.slideshow.macroEnabled.12',),
            'potx' => array('application/vnd.openxmlformats-officedocument.presentationml.template',),
            'potm' => array('application/vnd.ms-powerpoint.template.macroEnabled.12',),
            'ppam' => array('application/vnd.ms-powerpoint.addin.macroEnabled.12',),
            'sldx' => array('application/vnd.openxmlformats-officedocument.presentationml.slide',),
            'sldm' => array('application/vnd.ms-powerpoint.slide.macroEnabled.12',),
            'thmx' => array('application/vnd.ms-officetheme',),
            'onetoc' => array('application/onenote',),
            'onetoc2' =>array( 'application/onenote',),
            'onetmp' =>array( 'application/onenote',),
            'onepkg' => array('application/onenote',),
            
            'po' => array( 
			         "Content-Type: text/plain; charset=UTF-8;", "Content-Transfer-Encoding: 8bit\n",
			   ),
			//http://pki-tutorial.readthedocs.org/en/latest/mime.html
            'key' => array('application/pkcs8',), 
            'crt' => array('application/x-x509-ca-cert',), //VIRTUAL !!!!
           // 'crt' => array('application/x-x509-user-cert',),
      
            'cer' => array('pkix-cert',), 
           // 'pkicrt' => array('application/x-x509-user-cert',),
            'crl' => array('application/x-pkcs7-crl',),
			'pfx' => array('application/x-pkcs12',),
                        
			'bin' => array( 
			         "Content-Type: application/octet-stream", "Content-Transfer-Encoding: binary\n",
			   ),
			'dat' => array( 
			         "Content-Type: application/octet-stream", "Content-Transfer-Encoding: binary\n",
			         'Content-Disposition:attachment; filename="' . $file. '"',
			   ),
        );            
            
             
        $fnFromatFromHeaders = function() use($mime_types){
        	/**
			* 
			* @todo
			* 
			*/
		    return false;
		    
			  $headers = \webfan\App::God()-> {'?request_headers'}();
            	  if(isset($headers['Accept'])){
					$accepts = explode(',', $headers['Accept']);
					if(count($accepts) === 1){
						$_ = explode('/', $accepts[0]);
						$_ = explode(';', $_[1]);
						$_ = explode('+', $_[0]);
						if('*' !== $_s[0]){
							return ((isset($mime_types[$_s[0]])) ? $_s[0] : false) ;
						}
						
					}				  	
				  }
		    return false;		  
		};
		    
            
           if(null === $format || false === $format || !isset($mime_types[$format])){
           	
           	$fromHeaders = $fnFromatFromHeaders();
           	
		    $_e = explode('.', $file);
            $_e = array_reverse($_e);
            $extension = (count($_e) > 1) ? $_e[0] : '';
            if('?' === $format){
            	$format = $extension;
            	if( !isset($mime_types[$format]) && false !== $fromHeaders){
            	  $format = $fromHeaders;
            	}
            }elseif('?:extension' === $format){
            	$format = $extension;
            }elseif('?:headers' === $format){
            	$format = $fromHeaders;
            }

		   } 
		
		

		if(null !== $format && false !== $format){
			if(true === $apply)$THIS->format = $format;
			return ((isset($mime_types[$format])) ? $mime_types[$format] : false);
		}else{
			return $mime_types;
	    }
     }))
     
     ;
        
         
    
   
        	
       return $this;
	}
 	
 } 




--2222EVGuDPPT
Content-Type: application/vnd.frdl.script.php;charset=utf-8
Content-Disposition: php ;filename="$DIR_LIB/frdl/webfan/App.php";name="class frdl\webfan\App"

<?php
/**
 * 
 * Copyright  (c) 2015, Till Wehowski
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 *    must display the following acknowledgement:
 *    This product includes software developed by the frdl/webfan.
 * 4. Neither the name of frdl/webfan nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY frdl/webfan ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL frdl/webfan BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * 
 *  @author 	Till Wehowski <php.support@webfan.de>
 *  @package    webfan://webfan.App.code
 *  @uri        /v1/public/software/class/webfan/frdl.webfan.App/source.php
 *  @file       frdl\webfan\App.php
 *  @role       project/ Main Application Wrap 
 *  @copyright 	2015 Copyright (c) Till Wehowski
 *  @license 	http://look-up.webfan.de/bsd-license bsd-License 1.3.6.1.4.1.37553.8.1.8.4.9
 *  @license    http://look-up.webfan.de/webdof-license webdof-license 1.3.6.1.4.1.37553.8.1.8.4.5
 *  @link 	http://interface.api.webfan.de/v1/public/software/class/webfan/frdl.webfan.App/doc.html
 *  @OID	1.3.6.1.4.1.37553.8.1.8.8 webfan-software
 *  @requires	PHP_VERSION 5.3 >= 
 *  @requires   webfan://webfan.Autoloading.SourceLoader.code
 *  @api        http://interface.api.webfan.de/v1/public/software/get/1/
 *  @reference  http://www.webfan.de/install/
 *  @implements Singletone
 *  @implements StreamWrapper
 * 
 */
namespace frdl\webfan;

if(!class_exists('\frdl\A') && file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR .'A.php')){
	 require __DIR__ . DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR .'A.php';
}


class App extends \frdl\A
{
		
	const NS = __NAMESPACE__;
	const DS = DIRECTORY_SEPARATOR;
	
	const LOADER = 'webfan\Loader';
	
	protected static $instance = null;
	
	protected $app;
	
	protected $E_CALL = E_USER_ERROR;
	protected $wrap;
	/**
	* 
	* @public _ - current shortcut [mixed]
	* 
	*/
	public $_; 
	
	/**
	 * Stream Properties
	 */
	public $context = array();
	protected $data;
	protected $chunk;
	public $buflen;
	protected $pos = 0;
	protected $read = 0; 	
	protected $Controller;
	

	
	protected $LoaderClass =null;
	
	protected $public_properties_read =  array('app', 'wrap', 'wrappers', 'shortcuts' ,'LoaderClass');
	
	

	
	protected function __construct($init = false, $LoaderClass = self::LOADER, $name = '', $branch = 'dev-master', 
	   $version = 'v1.0.2-beta.1', $meta = array())
	 {
	    $this->app = new \stdclass;	
            $this->app->name = $name;
	    $this->app->branch = $branch;
	    $this->app->version = $version;
	    $this->app->meta = $meta;
	    $this->wrap = array();
	    $this->shortcuts = array();
            $this->setAutoloader($LoaderClass);
	    if($init === true)$this->init();
	}
	
	
    public function &__get($name)
    {
    	
      $retval = null;	
      if (in_array($name, $this->public_properties_read )){
           $retval = $this->{$name};
           return $retval;
	  }
      
        trigger_error('Not fully implemented yet or unaccesable property: '.get_class($this).'->'.$name,  $this->E_CALL);	

        return $retval;
    }		 


    public static function God($init = false, $LoaderClass = self::LOADER, $name = '', $branch = 'dev-master', 
	   $version = 'v1.0.2-beta.1', $meta = array()){
        return self::getInstance( $init, $LoaderClass, $name, $branch ,   $version, $meta );
   }
	 

  	public function init(){
	 $this->addShortCut('$', array($this,'addShortCut'))
	   
	  ;		
	  
	$this->_ = (function(){
			     return call_user_func_array(array($this,'$'), func_get_args());
		   });
	
     $this->wrap = array( 
		         'c' => array(
				        self::LOADER=>  array($this->LoaderClass, null), 
         		        'webfan\App' =>  array(__CLASS__, null),
				 ),
		         'f' => array( ),
		);

      $this ->applyAliasMap(true)
            ->mapWrappers(null)
			->init_stream_wrappers(true) 
			->Autoloader(true) 
		       ->autoload_register() 
		       -> j()
	        ;
                /**
                 * ToDo: Load Application Config and Components...
                 * */
                 
                 
		return $this;
    }
	
	  
	public function setAlias($component, $alias, $default, $abstract_parent, $interfaces = array()){
		$this->wrap['aliasing']['schema'][$component] = array(
		   'alias' => $alias, 'default' => $default, 'abstract_parent' =>$abstract_parent, 
		   'interfaces' => $interfaces
		 );
		return $this;
	}
	
	//todo : compinent registry
	public function setAliasMap($aliasing = null){
		$this->wrap['aliasing'] = (is_array($aliasing)) ? $aliasing
		 : array( 
				      'schema' => array(
					      '1.3.6.1.4.1.37553.8.1.8.8.5.65.8.1.1' => array('name' => 'Autoloader', 'alias' => self::LOADER, 'default' => &$this->LoaderClass,
					                           'abstract_parent' => 'frdl\webfan\Autoloading\SourceLoader', 
					                           'interfaces' => array() ),
					      '1.3.6.1.4.1.37553.8.1.8.8.5.65.8.1.2' => array('name' => 'Application Main Controller', 'alias' => 'webfan\App','default' => 'frdl\webfan\App',
					                           'abstract_parent' => 'frdl\webfan\App', 
					                           'interfaces' => array() ),
					      '1.3.6.1.4.1.37553.8.1.8.8.5.65.8.1.3' => array('name' => 'cmd parser', 'alias' => 'webfan\Terminal','default' =>'frdl\aSQL\Engines\Terminal\Test',
					                           'abstract_parent' => 'frdl\aSQL\Engines\Terminal\CLI', 
					                           'interfaces' => array() ),
					      '1.3.6.1.4.1.37553.8.1.8.8.5.65.8.1.4' => array('name' => 'BootLoader', 'alias' => 'frdl\AC','default' => 'frdl\ApplicationComposer\ApplicationComposerBootstrap',
					                           'abstract_parent' => 'frdl\ApplicationComposer\ApplicationComposerBootstrap', 
					                           'interfaces' => array() ),
						  '1.3.6.1.4.1.37553.8.1.8.8.5.65.8.1.5' => array('name' => 'API REST CLient', 'alias' => 'frdl\Client\RESTapi', 'default' => 'webdof\Webfan\APIClient',
					                           'abstract' => null, 
					                           'interfaces' => array() ), 
					  ),
				 );
				 
		return $this;		 
	}


    public function mapWrappers($wrappers  = null){
    	$this->wrappers = (is_array($wrappers)) ? $wrappers
    	  : array(  
	     'webfan' => array(
		         'tld' => array(   
				        'code' => 'webfan\Loader',
 
                  ),
		  ),
	      'frdl' => array(  
		  
		  ),
	      'homepagespeicher' => array(
		  
		  ),
	      'frdlweb' => array(  
		  
		  ),
	      'outshop' => array(  
		  
		  ),
	      'startforum' => array(  
		  
		  ),	 
	      
	      'wehowski' => array(  
		  
		  ),		
	      'till' => array(  
		  
		  ),		        
	  );
		
		return $this;		 
   }
	

   public function setAutoloader($LoaderClass = self::LOADER, &$success = false){
      $this->LoaderClass = $LoaderClass;
	  return $this;
   }



    public function init_stream_wrappers($overwrite = true){
 		 foreach($this->wrappers as $protocoll => $wrapper){
		       $this->_stream_wrapper_register($protocoll, $overwrite); 	
	     }
		return $this;
    }
	
		
	public function mapAliasing($apply = false){
		foreach($this->wrap['aliasing']['schema'] as $OID => $map){
			$this->wrap['c'][$map['alias']] = array($map['default'],null, $OID);
			if(true===$apply){
				$this->addClass($map['default'], $map['alias'],TRUE, $success );
			}
		}
		return $this; 	
	}
	
	
   public function Autoloader($expose = false){
     $component = '1.3.6.1.4.1.37553.8.1.8.8.5.65.8.1.1';
	 
	 if(null===$this->LoaderClass){
	  foreach($this->wrap['c'] as $alias => $info){
	 	if($component !== $info[2] || true !== $info[1] )continue;
             $this->LoaderClass = $info[0];
		 break;
	  }
	 }
	$Loader = (class_exists('\\'.$this->LoaderClass) ) ? call_user_func('\\'.$this->LoaderClass.'::top') 
		          : call_user_func('\\'.$this->wrap['aliasing']['schema'][$component]['default'].'::top') ;
				 
	 return (true === $expose) ? $Loader : $this;
   }
	
		
	public function applyAliasMap($retry = false){
    	foreach($this->wrap['c'] as $v => $o){
			if(null === $o[1] || (true === $retry && false === $o[1]))$this->addClass($o[0], $v,true, $success);
		}		 
		return $this; 	
	}

	
	 		
	public function __toString(){
		return (string)$this->app->name;
	}		
	
	
	
   public static function getInstance($init = false, $LoaderClass = self::LOADER, $name = '', $branch = 'dev-master', 
	   $version = 'v1.0.2-beta.1', $meta = array())
     {
       if (NULL === self::$instance) {
           self::$instance = new self($init, $LoaderClass, $name, $branch, $version , $meta);
       }
       return self::$instance;
     }
	 	
		
		
   protected function _fnCallback($name){
		// A
		  if(isset($this->shortcuts[$name])){
		  	   if(is_callable($this->shortcuts[$name]))return $this->shortcuts[$name];
		  } 
			  
			  
			  
		 //B 	  
		  	
		 $name = str_replace('\\','.',$name);

		 if(strpos($name,'.')!==false || strpos($name,'->')!==false || strpos($name,'::')!==false){
		 	  
			 if(strpos($name,'->')===false && strpos($name,'::')===false){
			   $n = explode('.', $name);
			   $method =  array_pop($n);
			   $name = implode('\\', $n);		 	
			   return array($name, $method);
			 }elseif( strpos($name,'->')!==false){
			 	 $n = explode('->', $name, 2);
				 $static = false;
			 }elseif(strpos($name,'::')!==false){
			 	 $n = explode('::', $name, 2);
				 $static = true;
			 }
             
			   $method =  array_pop($n);
			   $n = explode('.', $n[0]);
			   $name = implode('\\', $n);			 
			   return ($static === false) ? array($name, $method) : $name.'::'.$method;
		      		    
		 }
	} 
	 
    public function __call($name, $arguments)
    {
    	
		if(isset($this->wrap['f'][$name])){
    	try{
    	     return call_user_func_array($this->wrap['f'][$name],$arguments);
		}catch(Exeption $e){
		     trigger_error($e->getMesage().' '.__METHOD__.' '.__LINE__, $this->E_CALL);
		}
		}

   
    	try{
    		  $c = $this->_fnCallback($name);
    	      if(is_callable($c))call_user_func_array($c,$arguments);
			  return $this;
		}catch(Exeption $e){
		     trigger_error($e->getMesage().' '.__METHOD__.' '.__LINE__, $this->E_CALL);
			 return $this;
		}		
		
		
		 trigger_error($name.' not defined in '.__METHOD__.' '.__LINE__, $this->E_CALL);
		 return $this;
    }	 
	
	
	
	
	
    public static function __callStatic($name, $arguments)
    {
    	if(isset(self::God(false)->wrap['f'][$name])){
    	try{
    	       return call_user_func_array(self::God(false)->wrap['f'][$name],$arguments);
		}catch(Exeption $e){
		     trigger_error($e->getMesage().' '.__METHOD__.' '.__LINE__, self::God(false)->E_CALL);
		}
		}
		
	
	    try{
	    	  $c = self::God()->_fnCallback($name);
    	      if(is_callable($c))call_user_func_array($c,$arguments);
			  return self::God();
		}catch(Exeption $e){
		     trigger_error($e->getMesage().' '.__METHOD__.' '.__LINE__, self::God(false)->E_CALL);
			  return self::God();
		}	
		
		
		 trigger_error($name.' not defined in '.__METHOD__.' '.__LINE__, $this->E_CALL);
		 return self::God();
    }	
	
	

   public function addStreamWrapper( $protocoll, $tld, $class, $overwrite = true  ) {
          if(!isset($this->wrappers[$protocoll]))$this->wrappers[$protocoll] = array();
          if(!isset($this->wrappers[$protocoll]['tld']))$this->wrappers[$protocoll]['tld'] = array();		  
          $this->wrappers[$protocoll]['tld'][$tld] = $class; 
		  $this->_stream_wrapper_register($protocoll, $overwrite);
          return $this;
    }	
   
   
   public function addClass($Instance, $Virtual, $autoload = TRUE, &$success = null  ) {
    	$success =  ($Instance !== $Virtual) ? class_alias( $Instance, $Virtual, $autoload) : true;
		$this->wrap['c'][$Virtual]= array( (is_object($Instance)) ? get_class($Instance) : $Instance, $success);
        return $this;
    }
   
	public function addFunc($name, \Closure $func){
		$this->wrap['f'][$name] = $func; 
		return $this; 	
	}
	
   
   protected function _stream_wrapper_register($protocoll, $overwrite = true, &$success = null){
   		         if (in_array($protocoll, stream_get_wrappers())) {
		         	        if(true !== $overwrite){
                                $success = false;
								return $this;
						    }		         	        		
		         	        stream_wrapper_unregister($protocoll);	
				 }
		        $success = stream_wrapper_register($protocoll, get_class($this));	 
		return $this; 	
   }


	
	
	
	/**
	 * Streaming Methods
	 */	
   public function stream_open($url, $mode, $options = STREAM_REPORT_ERRORS, &$opened_path = null){
    	$u = parse_url($url);
	    $c = explode('.',$u['host']);
		$c = array_reverse($c);
		
		$this->Controller = null;
		$cN = (isset(self::God()->wrappers[$u['scheme']]['tld'][$c[0]]))
		          ?self::God()->wrappers[$u['scheme']]['tld'][$c[0]]
				  :false;
		
		if(false!==$cN){
			try{
			  $this->Controller = new $cN;
			}catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_NOTICE);
				return false;
			}
		}else{
				trigger_error('Stream handler for '.$url.' not found.', E_USER_NOTICE);
				return false;	
		}
				
    	return  call_user_func(array($this->Controller, __FUNCTION__),$url, $mode, $options );
    }
    public function dir_closedir(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    public function dir_opendir($path , $options){return  call_user_func(array($this->Controller, __FUNCTION__), $path , $options );}
    public function dir_readdir(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    public function dir_rewinddir(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    public function mkdir($path , $mode , $options){return  call_user_func(array($this->Controller, __FUNCTION__), $path , $mode , $options );}
    public function rename($path_from , $path_to){return  call_user_func(array($this->Controller, __FUNCTION__), $path_from , $path_to );}
    public function rmdir($path , $options){return  call_user_func(array($this->Controller, __FUNCTION__), $path , $options );}
    public function stream_cast($cast_as){return  call_user_func(array($this->Controller, __FUNCTION__), $cast_as );}
    public function stream_close(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    function stream_eof(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    public function stream_flush(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    public function stream_lock($operation){return  call_user_func(array($this->Controller, __FUNCTION__), $operation );}
    public function stream_set_option($option , $arg1 , $arg2){return  call_user_func(array($this->Controller, __FUNCTION__), $option , $arg1 , $arg2 );}
    public function stream_stat(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    public function unlink($path){return  call_user_func(array($this->Controller, __FUNCTION__), $path );}
    public function url_stat($path , $flags){return  call_user_func(array($this->Controller, __FUNCTION__), $path , $flags );}
    function stream_read($count){return  call_user_func(array($this->Controller, __FUNCTION__), $count );}
    function stream_write($data){return  call_user_func(array($this->Controller, __FUNCTION__), $data) ;}
    function stream_tell(){return  call_user_func(array($this->Controller, __FUNCTION__) );}
    function stream_seek($offset, $whence){return  call_user_func(array($this->Controller, __FUNCTION__), $offset, $whence );}
    function stream_metadata($path, $option, $var){return  call_user_func(array($this->Controller, __FUNCTION__), $path, $option, $var);}
     
	
}


--2222EVGuDPPT
Content-Type: application/vnd.frdl.script.php;charset=utf-8
Content-Disposition: php ;filename="$DIR_LIB/frdl/common/Stream.php";name="class frdl\common\Stream"

<?php
/**
 * Copyright  (c) 2015, Till Wehowski
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of frdl/webfan nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY frdl/webfan ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL frdl/webfan BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 *  shared by yannick http://php.net/manual/de/class.streamwrapper.php#92277
 * 
 */
namespace frdl\common;
 
interface Stream
{
     function stream_open($url, $mode, $options = STREAM_REPORT_ERRORS, &$opened_path = null);
     public function dir_closedir();
     public function dir_opendir($path , $options);
     public function dir_readdir();
     public function dir_rewinddir();
     public function mkdir($path , $mode , $options);
     public function rename($path_from , $path_to);
     public function rmdir($path , $options);
 	 public function stream_cast($cast_as);
 	 public function stream_close();
     public function stream_eof();
     public function stream_flush();
     public function stream_lock($operation);
     public function stream_set_option($option , $arg1 , $arg2);
     public function stream_stat();
     public function unlink($path);
     public function url_stat($path , $flags);
     public function stream_read($count);
     public function stream_write($data);
     public function stream_tell();
     public function stream_seek($offset, $whence);
     public function stream_metadata($path, $option, $var);
 
}


--2222EVGuDPPT
Content-Type: application/vnd.frdl.script.php;charset=utf-8
Content-Disposition: php ;filename="$DIR_LIB/frdl/webfan/Autoloading/Loader.php";name="class frdl\webfan\Autoloading\Loader"

<?php
/**
 * 
 * Copyright  (c) 2015, Till Wehowski
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 *    must display the following acknowledgement:
 *    This product includes software developed by the frdl/webfan.
 * 4. Neither the name of frdl/webfan nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY frdl/webfan ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL frdl/webfan BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
namespace frdl\webfan\Autoloading;
 
abstract class Loader
{
     abstract function  autoload_register  ();
     abstract function  addLoader  ( $Autoloader ,  $throw  =  true ,  $prepend  =  true );
     abstract function  unregister  ( $Autoloader );
     abstract function  addPsr0  ( $prefix ,  $base_dir ,  $prepend  =  true );
     abstract function  addNamespace  ( $prefix ,  $base_dir ,  $prepend  =  true );
     abstract function  addPsr4  ( $prefix ,  $base_dir ,  $prepend  =  true ) ;
     abstract function  Psr4  ( $class ) ;
     abstract function  loadClass  ( $class );
     abstract function  Psr0  ( $class ) ;
     abstract function  routeLoadersPsr0  ( $prefix ,  $relative_class ) ;
     abstract function  setAutloadDirectory  ( $dir ) ;
     abstract function  routeLoaders  ( $prefix ,  $relative_class );
     abstract protected function  inc  ( $file );
     abstract function  classMapping  ( $class ) ;
     abstract function  class_mapping_add  ( $class ,  $file , & $success  =  null );
     abstract function  class_mapping_remove  ( $class ) ;
     abstract function  autoloadClassFromServer  ( $className ) ;
    
   
}


--2222EVGuDPPT
Content-Type: application/vnd.frdl.script.php;charset=utf-8
Content-Disposition: php ;filename="$DIR_LIB/frdl/webfan/Autoloading/SourceLoader.php";name="class frdl\webfan\Autoloading\SourceLoader"

<?php
/**
 * 
 * Copyright  (c) 2015, Till Wehowski
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 *    must display the following acknowledgement:
 *    This product includes software developed by the frdl/webfan.
 * 4. Neither the name of frdl/webfan nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY frdl/webfan ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL frdl/webfan BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * 
 *  @author 	Till Wehowski <php.support@webfan.de>
 *  @package    frdl\webfan\Autoloading\SourceLoader
 *  @uri        /v1/public/software/class/webfan/frdl.webfan.Autoloading.SourceLoader/source.php
 *  @file       frdl\webfan\Autoloading\SourceLoader.php
 *  @role       Autoloader 
 *  @copyright 	2015 Copyright (c) Till Wehowski
 *  @license 	http://look-up.webfan.de/bsd-license bsd-License 1.3.6.1.4.1.37553.8.1.8.4.9
 *  @license    http://look-up.webfan.de/webdof-license webdof-license 1.3.6.1.4.1.37553.8.1.8.4.5
 *  @link 	http://interface.api.webfan.de/v1/public/software/class/webfan/frdl.webfan.Autoloading.SourceLoader/doc.html
 *  @OID	1.3.6.1.4.1.37553.8.1.8.8 webfan-software
 *  @requires	PHP_VERSION 5.3 >= 
 *  @requires   webfan://frdl.webfan.App.code
 *  @api        http://interface.api.webfan.de/v1/public/software/class/webfan/
 *  @reference  http://www.webfan.de/install/
 *  @implements StreamWrapper
 * 
 */
namespace frdl\webfan\Autoloading;
use frdl\common;


class SourceLoader extends Loader
{
    const NS = __NAMESPACE__;
    const DS = DIRECTORY_SEPARATOR;
    const SESSKEY = __CLASS__;			
	/**
	 * PKI
	 */
    const DISABLED = 0;
    const OPENSSL = 1;
    const PHPSECLIB = 2;

    const E_NORSA = 'No RSA library selected or supported';
    const E_NOTIMPLEMENTED = 'Sorry thisd is not implemented yet';    
    

    const B_SIGNATURE = "-----BEGIN SIGNATURE-----\r\n";
    const E_SIGNATURE = "-----END SIGNATURE-----";

    const B_CERTIFICATE = "-----BEGIN CERTIFICATE-----\r\n";
    const E_CERTIFICATE = "-----END CERTIFICATE-----";

    const B_PUBLIC_KEY = "-----BEGIN PUBLIC KEY-----\r\n";
    const E_PUBLIC_KEY = "-----END PUBLIC KEY-----";

    const B_RSA_PRIVATE_KEY = "-----BEGIN RSA PRIVATE KEY-----\r\n";
    const E_RSA_PRIVATE_KEY = "-----END RSA PRIVATE KEY-----";

    const B_KEY = "-----BEGIN KEY-----\r\n";
    const E_KEY = "-----END KEY-----";
 
    const B_LICENSEKEY = "-----BEGIN LICENSEKEY-----\r\n";
    const E_LICENSEKEY = "-----END LICENSEKEY-----";


    public $sid;
	
    protected $lib;
	
	
	 
	/**
	 * Stream Properties
	 */
	protected $Client;
	public $context = array();
	protected $data;
	protected $chunk;
	public $buflen;
	protected $pos = 0;
	protected $read = 0; 
	public static $id_repositroy;
	public static $id_interface;	
	public static $api_user;
	public static $api_pass;	
	protected $eof = false;
	protected $mode;
	
	
        protected $dir_autoload;
	protected static $config_source;
        protected $autoloaders = array();
        protected $autoloadersPsr0 = array();
	protected $classmap = array();
	protected $isAutoloadersRegistered = false;
		
	protected $interface;
	
	/**
	 *  "Run Time Cache" / Buffer
	 */
	protected static $rtc;
	
	protected static $instances = array();
	
	 
	protected $buf = array(
	  'config' => array(),
          'opt' => array(),
          'sources' => array(),
	);
	
	function __construct($pass = null) 
	 {
	   $this->sid = count(self::$instances);
	   self::$instances[$this->sid] = &$this;	
	   
	   $this->interface = null;	
	   self::$config_source = array( 
	 'install' =>  false,
         'dir_lib' => false,
         'session' => false,
         'zip_stream' => false,
         'append_eval_to_file' => false,
         
	   );
	   $this->dir_autoload = '';	
	   self::repository(((!isset($_SESSION[self::SESSKEY]['id_repository']))?'frdl':$_SESSION[self::SESSKEY]['id_repository']));	 
	   self::$id_interface =  'public';	 
	   self::$api_user = '';
	   self::$api_pass = '';
	   $this->Defaults(true);
	   $this->set_pass($pass);
	 }


  public function j(){
  	 return \webfan\App::God();
  }
	 
	 
  public static function top(){
  	  if(0 === count(self::$instances))return new self;
  	  return self::getStream(0);
  }	 
	 
	 
  public static function getStream($sid){
  	  return (isset(self::$instances[$sid])) ? self::$instances[$sid] : null;
  }	 	 
	 
  public static function repository($id = null){
  	if($id !== null)$_SESSION[self::SESSKEY]['id_repository'] = $id;
	self::$id_repositroy = &$_SESSION[self::SESSKEY]['id_repository'];
	return self::$id_repositroy;
  }	 
	 
  public function set_interface(Array &$interface = null){
  	 $this->interface = (is_array($interface)) ? $interface : null;
	 return $this;
  }	 
	 
  public function config_source($key = null, $value = null){
  	   if(!is_string($key))return self::$config_source;
	   if(!isset(self::$config_source[$key]))return false;
	   self::$config_source[$key] = $value;
	   return true;
  }  
	 

	 
  public function Defaults($set = false){
          $config = array( 
  'host' => null,
  'IP' => null,
  'uid' => 0,
  'encrypted' => true,
  'e_method' => 2,
  'c_method' => 1,
  'source' => $this->config_source(),
  'ERROR' => E_USER_WARNING,
  'ini' => array( 
      'display_errors_details' => false,
      'pev' => array( 
           'CUSTOM' => null,
           'REQUEST' => true,
	       'HOST' => $_SERVER['SERVER_NAME'],
	     //  'IPs' => $App->getServerIp(),
	       'PATH' => null,
	   ),
	  ), 
 
     
	); 
	
	
		  
		  if($set === true){
		  	  $this->set_config($config); 	
		  }
		  
		  return array(
		     'config' => $config,
		  );
		
	} 

	protected function set_pass($pass = null){
	   $this->pass = (is_string($pass)) ? $pass : mt_rand(10000,9999999).sha1($_SERVER['SERVER_NAME']).'faldsghdfshfdshjfdhjr5nq7q78bg2nda  jgf jtrfun56m8rtjgfjtfjtzurtnmrt tr765  $bbg r57skgmhmh';
	} 
	
	public function mkp(){
		
		$this->set_pass(null);
	     return $this;
	}
	
	public function set_config(&$config){
		$this->config = (is_array($config)) ? $config : $this->buf['config'];
		if(isset($this->config['source']) && is_array($this->config['source']))self::$config_source = &$this->config['source'];
        return $this;		
	}
	 



    public function installSource($class,&$code, &$error ='', &$config_source = null){
    	if($config_source === null)$config_source = &self::$config_source;
		if($config_source['install'] !== true)return null;
		if(!isset($code['php']))return false;
		if(isset($code['installed']) && $code['installed'] === true)return true;
		
	     $bs = new \frdl\webfan\Serialize\Binary\bin();
		 $code['doc'] = $bs->unserialize($this->unpack_license($code['d']));
			 		
		 $error = '';
		 $r = false;
		 
	    if(isset($config_source['dir_lib']) && is_string($config_source['dir_lib']) && is_dir($config_source['dir_lib'])){
	         $dir  = rtrim($config_source['dir_lib'],  self::DS . ' '). self::DS ;	
		     $filename = $dir.str_replace('\\', self::DS, $class).'.php'; 
			 $dir = realpath(dirname($filename)).self::DS;	
			 if(!is_dir($dir)){
			   if(!mkdir($dir, 0755, true)){
			   	  $error = 'Cannot create directory '.$dir.' and cannot save class '.$class.' in '.__METHOD__.' '.__LINE__;
			   	  trigger_error($error,E_USER_WARNING);
			   }
			 }		
             
			 if($error === ''){
               $file_header = "/**\n* File generated by frdl Application Composer : class : ".__CLASS__."\n**/\n";
			   $code = '<?php '."\n".$file_header."\n\$filemtime = ".time().";\n\$class_documentation = ".var_export($code['doc'], true).";\n".$code['php']."\n";
			 
			   $fp = fopen($filename, 'wb+');
	           fwrite($fp,$code);
	           fclose($fp);
			   if(file_exists($filename)){
			     $code['installed'] = true;
				 $r = true;  
			   }else{
			      $error = 'Cannot create file '.$filename.' and cannot save class '.$class.' in '.__METHOD__.' '.__LINE__;
			   	  trigger_error($error,E_USER_WARNING);
			   }
			 }
		}
			 
			 
			 
			 
	   return $r;	
    }



	
	public function patch_autoload_function($class){
		if(function_exists('__autoload'))return __autoload($class);
	}
		 
	public function autoload_register(){
		if(false !== $this->isAutoloadersRegistered){
		      trigger_error('Autoloadermapping is already registered.',E_USER_NOTICE);
			  return $this;
		}
        $this->addLoader(array($this,'Psr4'), true, true);	
        $this->addLoader(array($this,'Psr0'), true, false);				
	    $this->addLoader(array($this,'classMapping'), true, false);	
        $this->addLoader(array($this,'patch_autoload_function'), true, false);	
        $this->addLoader(array($this,'autoloadClassFromServer'), true, false);	
        $this->isAutoloadersRegistered = true;
        return $this;
	} 
    
    public function addLoader($Autoloader, $throw = true, $prepend = false){
       spl_autoload_register($Autoloader, $throw, $prepend);
	   return $this;
    }

    public function unregister( $Autoloader)
     {
        spl_autoload_unregister($Autoloader);
		return $this;
     } 	
	 
	 
	/**
	 * Psr-0
	 */ 				 
    public function addPsr0($prefix, $base_dir, $prepend = false)
    {
       $prefix = trim($prefix, '\\') . '\\';
       $base_dir = rtrim($base_dir, self::DS) . self::DS;	   
       if(isset($this->autoloadersPsr0[$prefix]) === false) {
            $this->autoloadersPsr0[$prefix] = array();
        }

      if($prepend) {
            array_unshift($this->autoloadersPsr0[$prefix], $base_dir);
        } else {
            array_push($this->autoloadersPsr0[$prefix], $base_dir);
        }
		
		return $this;
    }
	
	/**
	 * Psr-4
	 */ 			 
    public function addNamespace($prefix, $base_dir, $prepend = false)
    {
       return $this->addPsr4($prefix, $base_dir, $prepend);
    }
    public function addPsr4($prefix, $base_dir, $prepend = false)
    {
    
       $prefix = trim($prefix, '\\') . '\\';
       $base_dir = rtrim($base_dir, self::DS) . self::DS;	   
       if(isset($this->autoloaders[$prefix]) === false) {
            $this->autoloaders[$prefix] = array();
        }
	
      if($prepend) {
            array_unshift($this->autoloaders[$prefix], $base_dir);
        } else {
            array_push($this->autoloaders[$prefix], $base_dir);
        }
		
		return $this;
	}	 
    


    
    public function Psr4($class)
    {
    
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $file = $this->routeLoaders($prefix, $relative_class);
			if ($file) {
                return $file;
            }
            $prefix = rtrim($prefix, '\\');   
        }
		
        return false;       
    } 
    public function loadClass($class)
    {
       return $this->Psr4($class);
    }	
	
	
	
   public function Psr0($class)
    {
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $file = $this->routeLoadersPsr0($prefix, $relative_class);
            if ($file) {
                return $file;
            }
            $prefix = rtrim($prefix, '\\');   
        }
        return false;  
    }
  		
   public function routeLoadersPsr0($prefix, $relative_class)
    {
        if (!isset($this->autoloadersPsr0[$prefix])) {
            return false;
        }
        foreach ($this->autoloadersPsr0[$prefix] as $base_dir) {		
          if (null === $prefix || $prefix.'\\' === substr($relative_class, 0, strlen($prefix.'\\'))) {
            $fileName = '';
            $namespace = '';
            if (false !== ($lastNsPos = strripos($relative_class,  '\\'))) {
                $namespace = substr($relative_class, 0, $lastNsPos);
                $relative_class = substr($relative_class, $lastNsPos + 1);
                $fileName = str_replace('\\', self::DS, $namespace) . self::DS;
            }
            $fileName .= str_replace('_', self::DS, $relative_class) /* . '.php'  */;
            $file = ($base_dir !== null ? $base_dir . self::DS : '') . $fileName;
            if ($this->inc($file)) {
                return $file;
            }
          }
		}
	   return false;
    }		


    public function setAutloadDirectory($dir){
  	   if(!is_dir($dir))return false;
	   $this->dir_autoload = $dir;
	   if(substr($this->dir_autoload,-1,1) !== self::DS)$this->dir_autoload.=self::DS;
	   return true;	
    }	 
  		
    public function routeLoaders($prefix, $relative_class)
    {

        if (!isset($this->autoloaders[$prefix])) {
            return false;
        }
        foreach ($this->autoloaders[$prefix] as $base_dir) {
        	
            $file = $base_dir
                  . str_replace('\\', self::DS, $relative_class)
                  /* . '.php'  */
				   ;

		
            if ($this->inc($file)) {
                return $file;
            }
        }
        return false;
    }	
	
    protected function inc($file)
    {
    	if(substr($file,-4,4) === '.php'){
    		$file = $file; 
    	}else{
    		$file.= '.php';
    	}
		$file2= substr($file,0,-4).'.inc';
	
       if(file_exists($file)) {
             require $file;
            return true;
        }elseif(file_exists($file2)) {
             require $file2;
            return true;
        }
		
		
        return false;
    }	
		 
		 
	
	public function classMapping($class){
		if(isset($this->classmap[$class])){
            if ($this->inc($this->classmap[$class])) {
                return $this->classmap[$class];
            }			
		}
		
		return false;
	}
	
	
	public function class_mapping_add($class, $file, &$success = null){
		if(file_exists($file)){
		    $this->classmap[$class] = $file;
			$success = true;
	    }else{
			$success = false;
	    }
		
	   return $this;
	}
    
	public function class_mapping_remove($class){
		if(isset($this->classmap[$class]))unset($this->classmap[$class]);
	    return $this;
	}	
    		 
		 
		 
	protected function source_check($str){	 
		 $start = 'array';
		 $badwords = array('$',';', '?', '_', 'function ', 'class ');
	
		 foreach($badwords as $num => $s){
		 	if(strpos($str, $s)!== false)return false;
		 }
		 
		 if(substr($str,0,strlen($start)) !== $start)return false;
		 if(!preg_match('/[a-f0-9]{40}/', $str))return false;
		 
		 
		 return true;
	} 
	public function autoloadClassFromServer($className){
	
		  $classNameOrig = $className;
		  if(class_exists($className))return;	
		  if (!in_array('webfan', stream_get_wrappers())){
		  	trigger_error('Streamwrapper webfan is not registered. Call to webfan\App::init() required.', E_USER_ERROR);
			return;
		  }
		  $className = str_replace('\\', '.', $className);
		  $className = ltrim($className, ' .');
		  $RessourceFileName = 'webfan://'.$className.'.code';
		   
		  $fp = fopen($RessourceFileName, 'r');
		  $source = '';
		  if($fp){
		  	clearstatcache(); 
			clearstatcache(true,$RessourceFileName);   
			$stat = fstat($fp);
			$bufsize = ($stat['size'] <= 8192) ? $stat['size'] : 8192;
		  	while(!feof($fp) ){
		        $source .= fread($fp, $bufsize);
			}
		     fclose($fp);
		  }else{
		  	return false;
		  }
		  
		  
		if($source ===false || $source ==='' ){
	   			trigger_error('Cannot get source from the webfan code server ('.$RessourceFileName.')! '.__METHOD__.' '.__LINE__, E_USER_WARNING);
		     	return false;
            }
				  
	    $scheck = $this->source_check($source);			  
		if($scheck !== true){
	   			trigger_error('The source loaded from the code server looks malicious ('.$scheck.' '.$RessourceFileName.')! '.__METHOD__.' '.__LINE__, E_USER_WARNING);
		     	return false;			
		}  
		
		if(eval('$data = '.$source.';')===false){
	   			trigger_error('Cannot process the request to the source server by APIDClient ('.$RessourceFileName.')! '.__METHOD__.' '.__LINE__, E_USER_WARNING);
		     	return false;
            }
		
		$_defaults = $this->Defaults();
		$config =  self::$config_source;//$_defaults["config"];
		$opt = (isset($data['opt'])) ? $data['opt'] : $this->getOpt();
		$code = $data['source'];

        $sources = array();
		$sources[$classNameOrig] = $code; 

        if(is_array($this->interface)){
        	$opt['pass'] = $this->interface['API_SECRET'];
			$opt['rot1'] = $this->interface['rot1'];
			$opt['rot2'] = $this->interface['rot2'];
        }
        

		if($this->loadSources($sources,$opt, $config )===false){
		   		trigger_error('Cannot process the request to the source server by APIDClient ('.$className.')! '.__METHOD__.' '.__LINE__, E_USER_WARNING);
		     	return false;		
		}
		
		return $RessourceFileName;	  
	}
	 

    public function make_pass_3(&$opt){
             if(isset($opt['pwdstate']) && $opt['pwdstate'] === 'decrypted')return true;
             if(isset($opt['pwdstate']) && $opt['pwdstate'] === 'error')return false;
            if(!isset(self::$rtc['CERTS']))self::$rtc['CERTS'] = array();
            $hash = sha1($opt['CERT']);
            $u = parse_url($opt['CERT']);
          $url = $opt['CERT'];
           if(!isset(self::$rtc['CERTS'][$hash]) && ($u === false || !isset(self::$rtc['CERTS'][$url])))
               {
                    if($u !== false && count($u) >1 && !preg_match("/CERTIFICATE/", $opt['CERT']) ){
                     if(isset($u['scheme']) && isset($u['host'])){
                $h = explode('.',$u['host']);
                 $h = array_reverse($h);
                 if($h[0] === 'de' && ($h[1] === 'webfan' || $h[1] === 'frdl' )){
                 if(class_exists('\webdof\Http\Client')){
                 $Http = new \webdof\Http\Client();
                $post = array();
                $send_cookies = array();
                $r = $Http->request($opt['CERT'], 'GET', $post, $send_cookies, E_USER_WARNING);
                }else{
                	$c = file_get_contents($opt['CERT']);
					$r = array();
					$r['status'] = (preg_match("/CERTIFICATE/",$c)) ? 200 : 400;
					$r['body'] = $c;
                }
				
                if(intval($r['status'])===200){
               $CERT = trim($r['body']);
               }else{
                 $opt['pwdstate'] = '404';
                return false;
              }
               }
           }else{
                   $CERT = trim(file_get_contents($opt['CERT']));
                }
                   $key = $url;
                  if(!isset(self::$rtc['CERTS'][$key]))self::$rtc['CERTS'][$key] = array();
                 self::$rtc['CERTS'][$key]['crt'] = $CERT;
             }elseif(preg_match("/CERTIFICATE/", $opt['CERT'])){
             	    $key = $hash;
                    if(!isset(self::$rtc['CERTS'][$key]))self::$rtc['CERTS'][$key] = array();
                    $CERT = utf8_encode($opt['CERT']);
					$CERT=$this->loadPK($CERT);
					if($CERT===false){
				   	  trigger_error('Cannot procces certificate info in '.__METHOD__.' line '.__LINE__, E_USER_WARNING);
					  return false;
				   }
					$CERT=$this->save($CERT, self::B_CERTIFICATE, self::E_CERTIFICATE);
					self::$rtc['CERTS'][$key]['crt'] =$CERT;
				   
              }else{
				   	  trigger_error('Cannot procces certificate info in '.__METHOD__.' line '.__LINE__, E_USER_WARNING);
					  return false;
				   }
                 }elseif(isset(self::$rtc['CERTS'][$hash])){
                     $key = $hash;
                  }elseif(isset(self::$rtc['CERTS'][$url])){
                      $key = $url;
                  }else{
                  	 trigger_error('Cannot procces certificate info in '.__METHOD__.' line '.__LINE__, E_USER_WARNING);
					 return false;
                  }


            $this->setLib(1);
        if(!isset(self::$rtc['CERTS'][$key]['PublicKey'])){
              $PublicKey = $this->getPublKeyByCRT(self::$rtc['CERTS'][$key]['crt']);
             self::$rtc['CERTS'][$key]['PublicKey'] = $PublicKey;
           }
            $success = $this->decrypt($opt['pass'],self::$rtc['CERTS'][$key]['PublicKey'],$new_pass) ;
          if($success === true){
            $opt['pass'] = $new_pass;
           $opt['pwdstate'] = 'decrypted';
            }else{
               $opt['pwdstate'] = 'error';
		      // unset(self::$rtc['CERTS'][$key]);
            }
           return $success;
    } 

    protected function load(&$code, Array &$config = null, &$opt = array('pass' => null, 'rot1' => 5, 'rot2' => 3), $class = null){
	      $p = $this->_unwrap_code(((is_string($code)) ? $code : $code['c']));
		  
		  if(isset($opt['e']) && is_bool($opt['e']))$config['encrypted'] = $opt['e'];
		  if(isset($opt['m']))$config['e_method'] = $opt['m'];		   
		  
 	      if($config['encrypted'] === true && intval($config['e_method']) === 1){
 		   	 trigger_error('The options encryption method is deprecated in '.__METHOD__.' '.__LINE__,$config['ERROR']);
		     return false;		     
 	      }	 
		  
 	      if($config['encrypted'] === true && intval($config['e_method']) === 2){
 		     $p = trim($this->crypt($p, 'decrypt', $opt['pass'], $opt['rot1'], $opt['rot2']));
 	      }	 	
		  
 	      if($config['encrypted'] === true && intval($config['e_method']) === 3){
 	      	 if($this->make_pass_3($opt) == false){
		   	 trigger_error('Cannot decrypt password properly [1] from '.self::$id_repositroy.' for '.$class.' in '.__METHOD__.' '.__LINE__,$config['ERROR']);
		       return false;	      	 	
 	      	 }
 		     $p = trim($this->crypt($p, 'decrypt', $opt['pass'], $opt['rot1'], $opt['rot2']));
 	      }	
		  		  		  	
		   if(isset($code['s']) && $code['s'] !== sha1($p)){
	          	 $errordetail = ($config['ini']['display_errors_details'] === true)
			                  ? '<pre>'.sha1($p).'</pre><pre>'.$code['s'].'</pre><pre>'.$opt['pass'].' '.$opt['rot1'].' '.$opt['rot2'].'</pre>'
			                  : '';	   	
													  
		   	   trigger_error('Cannot decrypt source properly [2] from '.self::$id_repositroy.' for '.$class.' in '.__METHOD__.' '.__LINE__.$errordetail,$config['ERROR']);

			   return false;
		   }
		  
 	       $p = $this->unwrap_namespace($p);	   
		   $code['php'] = $p;
		   try{
	             $parsed = eval($p);
		   }catch(Exception $e){
		   	  $parsed = false;
		   }
          if($parsed === false){
          	 $errordetail = ($config['ini']['display_errors_details'] === true)
			                  ? '<pre>'.htmlentities($p).'</pre>'
			                  : '';
		     trigger_error('Parse Error in '.__METHOD__.' '.__LINE__.$errordetail,$config['ERROR']);
		     return false;
	      } else {
			   unset($code['c']);
		  } 
		  
		  $error = '';
		  $config_source = (isset($config['source'])) ? $config['source'] : self::$config_source;
		  $installed = $this->installSource($class,$code, $error, $config_source);
		  
		  usleep(75);
		  return true; 	
    }


    public function loadSource(&$code, Array &$config = null, &$opt = array('pass' => null, 'rot1' => 5, 'rot2' => 3), $class = null){
    	 return $this->load($code, $config, $opt, $class );
    }

    public function loadSources(&$sources, &$opt = array('pass' => null, 'rot1' => 5, 'rot2' => 3), Array &$config = null){
       $this->set_config($config); 	
       $this->mkp($config);	
       foreach($sources as $class => $code){
       	  if(class_exists($class))continue;
	      if($this->load($code, $config, $opt, $class) === false){
	      	return false;
	      }
       }
    	
       return true;	
    }
	
	
    public function crypt($data, $command = 'encrypt', $Key = NULL, $offset = 5, $chiffreBlockSize = 3)
	{
	   if($command ===  'encrypt'){
	    	$data = sha1(trim($data)).$data;	
			
			    $k = sha1($Key).$Key;
				
				$str = $data;
				$data = '';
				
				
				for($i=1; $i<=strlen($str); $i++)
				{
					$char 		= substr($str, $i-1, 1);
					$keychar 	= substr($k, ($i % strlen($k))-1, 1);
					$char 		= chr(ord($char)+ord($keychar));
					$data		.= $char;
				}
       }
	   if(!is_numeric($offset)||$offset<0)$offset=0;if(!isset($data)||$data==""||!isset($Key)||$Key==""){return FALSE;}$pos="0";for($i=0;$i<=(strlen($data)-1);$i++){$shift=($offset+$i)*$chiffreBlockSize;while($shift>=256){$shift-=256;}$char=substr($data,$i,1);$char=ord($char)+$shift;if($pos>=strlen($Key)){$pos="0";}$key=substr($Key,$pos,1);$key=ord($key)+$shift;if($command=="decrypt"){$key=256-$key;}$dataBlock=$char+$key;if($dataBlock>=256){$dataBlock=$dataBlock-256;}$dataBlock=chr(($dataBlock-$shift));if(!isset($crypted)){$crypted=$dataBlock;}else{$crypted.=$dataBlock;}$pos++;}
       if($command ===  'decrypt'){
 				$decrypt 	= '';
                $k = sha1($Key).$Key;
			
				for($i=1; $i<=strlen($crypted); $i++)
				{
					$char 		= substr($crypted, $i-1, 1);
					$keychar 	= substr($k, ($i % strlen($k))-1, 1);
					$char 		= chr(ord($char)-ord($keychar));
					$decrypt   .= $char;
				}      	   
       	   $crypted = substr($decrypt,strlen(sha1("1")),strlen($decrypt));
		   $hash_check = substr($decrypt,0,strlen(sha1("1")));
		   if(trim($hash_check) !== sha1($crypted) || sha1($crypted)==='da39a3ee5e6b4b0d3255bfef95601890afd80709'){
		   	 $crypted = false;
		   	 trigger_error('Broken data consistence in '.__METHOD__, E_USER_NOTICE);
		   }
	   }
       return $crypted;
	}	

   
    public function unwrap_namespace($s){
    	$s = preg_replace("/^(namespace ([A-Za-z0-9\_".preg_quote('\\')."]+);){1}/", '${1}'."\n", $s);
		return preg_replace("/(\nuse ([A-Za-z0-9\_".preg_quote('\\')."]+);)/", '${1}'."\n", $s);
    }
    	
    public function _unwrap_code($c){return trim(gzuncompress(gzuncompress(base64_decode(str_replace("\r\n\t","", $c))))," \r\n");}		
    public function unpack_license($l){return gzuncompress(gzuncompress(base64_decode(str_replace("\r\n", "", $l))));} 	
	function __destruct() {foreach(array_keys(get_object_vars($this)) as $value){unset($this->$value);}}
	
	
	/**
	 * PKI
	 */ 

   public function setLib($lib)
     {
        $this->lib = $lib;
	   return $this;
     } 

   public function save($data, $begin = "-----BEGIN SIGNATURE-----\r\n", $end = '-----END SIGNATURE-----')
     {
        return $begin . chunk_split(base64_encode($data)) . $end;
     }


   public function loadPK($str)
     {
       $data = preg_replace('#^(?:[^-].+[\r\n]+)+|-.+-|[\r\n]#', '', $str);
       return preg_match('#^[a-zA-Z\d/+]*={0,2}$#', $data) ? utf8_decode (base64_decode($data) ) : false;
     }

  public function error($error, $mod = E_USER_ERROR, $info = TRUE)
    {
      trigger_error($error.(($info === TRUE) ? ' in '.__METHOD__.' line '.__LINE__ : ''), $mod);
      return FALSE;
    }
    
    
  public function verify($data, $sigBin, $publickey, $algo = 'sha256WithRSAEncryption')
     {
        switch($this->lib)
          {
           case self::OPENSSL :
                  return $this->verify_openssl($data, $sigBin, $publickey, $algo);
                break;

           case self::PHPSECLIB :
                  return $this->verify_phpseclib($data, $sigBin, $publickey, $algo);
                break;
           case self::DISABLED :
           default :
                  return $this->error(self::E_NORSA, E_USER_ERROR);
                break;

          }

     }
    
	    
  public function getPublKeyByCRT($cert)
     {
        switch($this->lib)
          {
           case self::OPENSSL :
                  return $this->getPublKeyByCRT_openssl($cert);
                break;

           case self::PHPSECLIB :
                  return $this->error(self::E_NOTIMPLEMENTED, E_USER_ERROR);
                break;
           case self::DISABLED :
           default :
                  return $this->error(self::E_NORSA, E_USER_ERROR);
                break;

          }

     }
	 
  public function encrypt($data,$PrivateKey,&$out)
     {
        switch($this->lib)
          {
           case self::OPENSSL :
                  return $this->encrypt_openssl($data,$PrivateKey,$out);
                break;
        case self::PHPSECLIB :
                  return $this->error(self::E_NOTIMPLEMENTED, E_USER_ERROR);
                break;
           case self::DISABLED :
           default :
                  return $this->error(self::E_NORSA, E_USER_ERROR);
                break;

          }

     }
	 

  public function decrypt($decrypted,$PublicKey,&$out)
     {
        switch($this->lib)
          {
           case self::OPENSSL :
                  return $this->decrypt_openssl($decrypted,$PublicKey,$out);
                break;
        case self::PHPSECLIB :
                  return $this->error(self::E_NOTIMPLEMENTED, E_USER_ERROR);
                break;
           case self::DISABLED :
           default :
                  return $this->error(self::E_NORSA, E_USER_ERROR);
                break;

          }

     }
	 	 
  protected function encrypt_openssl($data,$PrivateKey,&$out) {  
     $PrivKeyRes = openssl_pkey_get_private($PrivateKey);
     return openssl_private_encrypt($data,$out,$PrivKeyRes); 
  }
  
  protected function decrypt_openssl($decrypted,$PublicKey,&$out) {  
        $pub_key = openssl_get_publickey($PublicKey);
        $keyData = openssl_pkey_get_details($pub_key);
        $pub = $keyData['key'];
        $successDecrypted = openssl_public_decrypt(base64_decode($decrypted),$out,$PublicKey, OPENSSL_PKCS1_PADDING);
		return $successDecrypted; 
  }
  


  protected function getPublKeyByCRT_openssl($cert)
    {
       $res = openssl_pkey_get_public($cert);
       $keyDetails = openssl_pkey_get_details($res);
       return $keyDetails['key'];
    }

     

  protected function verify_phpseclib($data, $sigBin, $publickey, $algo = 'sha256WithRSAEncryption')
      {
         $isHash = preg_match("/^([a-z]+[0-9]).+/", $algo, $hashinfo);
         $hash = ($isHash) ? $hashinfo[1] : 'sha256';

         $rsa = new Crypt_RSA();
         $rsa->setHash($hash);
         $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
         $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
         $rsa->loadKey($publickey);
         return (($rsa->verify($data, $sigBin) === TRUE) ? TRUE : FALSE);
      }


   protected function verify_openssl($data, $sigBin, $publickey, $algo = 'sha256WithRSAEncryption')
      {
        return ((openssl_verify($data, $sigBin, $publickey, $algo) == 1) ? TRUE : FALSE);
      }
	  
	  
	  	
	
	/**
	 * Streaming Methods
	 */
    public function init(){$args = func_get_args(); /** todo ... */ return $this;}
    public function DEFRAG(){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function stream_open($url, $mode, $options = STREAM_REPORT_ERRORS, &$opened_path = null){
    	$u = parse_url($url);
	    $c = explode('.',$u['host']);
		$c = array_reverse($c);
		
		$this->mode = $mode;
		
		if($c[0]==='code')$tld = array_shift($c);
		
		
		
		/**
		 * ToDo: APICLient
		 *    $this->Client = new \frdl\Client\RESTapi();
		 * 
		 *  URL Pattern / e.g. this Class:
		 *  http://interface.api.webfan.de/v1/public/software/class/webfan/frdl.webfan.Autoloading.SourceLoader/source.php
		 * 
		 */
        if(class_exists('\webdof\wHTTP') && class_exists('\webdof\Http\Client') && class_exists('\webdof\Webfan\APIClient')){ 
	      $this->Client = new \webdof\Webfan\APIClient();
		  $this->Client->prepare( 'http',
                          'interface.api.webfan.de',
                          'GET',
                          self::$id_interface,  //  i1234 
                          'software',
                          array(),  //post
                          array(),  //cookie
                          self::$api_user,
                          self::$api_pass,
                          'class',
                          'php',   //format ->hier: "php"
                          'source',
                           array(self::$id_repositroy,implode(".",array_reverse($c))),
                           array(), //get
                          1,
                          E_USER_WARNING);
						  
		 $this->eof = false;
		 $this->pos = 0;
    	 try{
               $r = $this->Client->request();
			   if(intval($r['status']) !== 200)return false;
			   $this->data = $r['body'];
	
		 }catch(Exception $e){
			trigger_error('Cannot process the request to '.$url, E_USER_WARNING);
			return false;
		 }  	
	   }else{
	      $url = 'http://interface.api.webfan.de/v1/'.self::$id_interface.'/software/class/'.self::$id_repositroy.'/'.implode(".",array_reverse($c)).'/source.php';
		  $data = file_get_contents($url);
		  if(false === $data){
		  	 return false;			  
		  }else{
		  	 $this->data = $data;
		  }
	   }
				  
	    return true;					  
    }
    public function dir_closedir(){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function dir_opendir($path , $options){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function dir_readdir(){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function dir_rewinddir(){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function mkdir($path , $mode , $options){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function rename($path_from , $path_to){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function rmdir($path , $options){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
 	public function stream_cast($cast_as){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
 	public function stream_close(){
         $this->Client = null;
	}
    public function stream_eof(){
    	$this->eof = ($this->pos >= strlen($this->data));
    	return $this->eof;
	}
    public function stream_flush(){
    	//echo $this->data;
    	$this->pos  = strlen($this->data);
		return $this->data;
	}
    public function stream_lock($operation){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function stream_set_option($option , $arg1 , $arg2){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function stream_stat(){
		 return array(  
		          'mode' => $this->mode,
		          'size' => strlen($this->data) * 8,
		 );
	}
    public function unlink($path){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function url_stat($path , $flags){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function stream_read($count){
    	 if($this->stream_eof())return  '';
		
    	 $maxReadLength = strlen($this->data) - $this->pos;
         $readLength = min($count, $maxReadLength);

        $p=&$this->pos;
        $ret = substr($this->data, $p, $readLength);
        $p +=  $readLength;
        return (!empty($ret)) ? $ret : '';  	
	}
    public function stream_write($data){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
    public function stream_tell(){return $this->pos;}
    public function stream_seek($offset, $whence){
    	
		
		
		$l=strlen($this->data);
        $p=&$this->pos;
        switch ($whence) {
            case SEEK_SET: $newPos = $offset; break;
            case SEEK_CUR: $newPos = $p + $offset; break;
            case SEEK_END: $newPos = $l + $offset; break;
            default: return false;
        }
        $ret = ($newPos >=0 && $newPos <=$l);
        if ($ret) $p=$newPos;
        return $ret;
	}
    public function stream_metadata($path, $option, $var){trigger_error('Not implemented yet: '.get_class($this).' '.__METHOD__, E_USER_ERROR);}
   
}

--2222EVGuDPPT
Content-Type: application/vnd.frdl.script.php;charset=utf-8
Content-Disposition: php ;filename="$DIR_LIB/frdl/webfan/Autoloading/Autoloader.php";name="class frdl\webfan\Autoloading\Autoloader"

<?php
/**
 * 
 * Copyright  (c) 2015, Till Wehowski
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 *    must display the following acknowledgement:
 *    This product includes software developed by the frdl/webfan.
 * 4. Neither the name of frdl/webfan nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY frdl/webfan ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL frdl/webfan BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
namespace frdl\webfan\Autoloading;
use frdl\common;
use frdl\common\Lazy;


final class Autoloader extends SourceLoader implements \frdl\common\Stream
{
	
}
--2222EVGuDPPT--
--3333EVGuDPPT
Content-Type: text/x-frdl-html-php-template;charset=utf-8
Content-Disposition: php ;filename="$__FILE__/templates/index.html";name="templates index.html"


<?php


$vm = $this;

$_htmls = implode("\n", $vm->context->html_contents);
$_htmls_state  = implode("\n", $vm->context->html_contents_state);




$api_client_url = \frdl\webfan\App::God(false)->apc_api_client_url();
$manifest_url = \frdl\webfan\App::God(false)->apc_manifest_url();

$favicon_url = \frdl\webfan\App::God(false)->apc_favicon_url();

$version_installer = $this->context->apc->config->version_installer;


echo <<<HTML
<!DOCTYPE html>
<html>
<head>
<title data-l10n-id="app_title">Webfan - Application Composer</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="lightblue" />
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

<meta name="flow.component.frdl.webfan.api.url" content="$api_client_url" />
<meta name="flow.component.frdl.webfan.version" content="$version_installer" />

<link rel="shortcut icon" href="$favicon_url" type="image/x-icon">
<link rel="manifest" href="$manifest_url" type="application/manifest+json">

<script type="text/javascript">
(function(){
	
	'use strict';
	
var libUrl = 'http://api.webfan.de/api-d/4/js-api/library.js';
var libMetaUrl = 'http://api.webfan.de/api-d/4/js-api/library.js#meta';
var libCoreSource = localStorage.getItem(libUrl);
var libMeta = localStorage.getItem(libMetaUrl);


if((null === libCoreSource || parseInt(libMeta) < new Date().getTime() - 24 * 60 * 60 * 1000 || parseInt(libMeta) < 1478981535857) && !!navigator.onLine){
 if(window.XMLHttpRequest)
  {
 	var request = new XMLHttpRequest();
  } else if(window.ActiveXObject)
  {
	  var request = new ActiveXObject('Microsoft.XMLHTTP');
  }
			

  var loadLib = function(){
	if (request.readyState !== 4)
	return;
	
	libCoreSource = request.responseText;
	localStorage.setItem(libUrl, libCoreSource);
	localStorage.setItem(libMetaUrl, new Date().getTime());
  };


  request.onload = loadLib;
  request.onreadystatechange = loadLib;
try{ 
  request.open('GET', libUrl, false);	
  request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  request.send();	
}catch(err){
	if(!!console){
		console.warn(err);
		(function(){
				var h=document.getElementsByTagName("head",document)[0];var s=document.createElement('script');s.setAttribute('src','http://api.webfan.de/api-d/4/js-api/library.js');h.insertBefore(s,h.firstChild);
		}());
	}
} 
  
}else if(null === libCoreSource && !navigator.onLine){
    window.addEventListener("online", function() {
       window.location.reload();
    }, true);	
	return alert('The library was not installed, please go online to install it!');
}

try{
  window.eval(libCoreSource);
}catch(err){
	if(!!console){
		console.warn(err);
		console.trace(err);
	}
	if(!frdl || !webfan){
		localStorage.removeItem(libUrl);
		localStorage.removeItem(libMetaUrl);
	}
}

}());
</script>
<link rel="package" type="application/package" href="https://github.com/frdl/webfan/archive/master.zip">





<script type="text/javascript">
(function(){

var p = null, loadTxt = null, lastModuleLoaded = new Date().getTime();

(function(){

	'use strict';

function checkForErrors(){
		
	
 ((!!webfan && 'function'===webfan.\$Async)?webfan.\$Async:setTimeout)(function(){
 	
 	if(new Date().getTime() - lastModuleLoaded < 15000){
		return  ((!!webfan && 'function'===webfan.\$Async)?webfan.\$Async:setTimeout)(function(){
 	          checkForErrors();
         },1000);	 
	}
 	
 	if(null === loadTxt)loadTxt = \$('div[data-flow-mod="intro.DIV"]').find('*[flow-str="loading"]');
 	
	      loadTxt.html('<p><span flow-hint="error checking 1">Checking for errors...</span><p>');
	      loadTxt.css('color', 'orange');	
	      loadTxt.find('*[flow-hint="error checking 1"]').css('text-decoration', 'blink');	
	      
 ((!!webfan && 'function'===webfan.\$Async)?webfan.\$Async:setTimeout)(function(){
 	
  	if(new Date().getTime() - lastModuleLoaded < 15000){
		return  ((!!webfan && 'function'===webfan.\$Async)?webfan.\$Async:setTimeout)(function(){
 	          checkForErrors();
         },1000);	 
	}	
 	
 	      loadTxt.find('*[flow-hint="error checking 1"]').fadeOut('slow');	
	      loadTxt.html('<p><span>Sorry, something went wrong</span>!</p>');
	      loadTxt.css('color', 'red');	
	    //  loadTxt.append('<p>Youn may refresh your browsercaches.</p>');	      
	      loadTxt.append('<p><a href="#" onclick="location.reload();">restart</a></p>');
	      loadTxt.append('<p><a href="#" onclick="require.clear();localStorage.clear();location.reload();">restart + clear</a></p>');
	      loadTxt.append('<p><a href="http://frdl.github.io/frdl/">Platformstatus</a></p>');
 },15000);	      
	      
 },15000);
}

 
  
 
frdl.require.state.on('resolved', function(){
	lastModuleLoaded = new Date().getTime();
	if(null === loadTxt)loadTxt = \$('div[data-flow-mod="intro.DIV"]').find('*[flow-str="loading"]');
	if(null === loadTxt)return;
	loadTxt.css('color', 'green');
		
	   if('undefined' === typeof arguments[0].identifier){
	   	  var str = '['+ (typeof arguments[0].module).toUpperCase() +']...';
	   }else{
	   	 var str = '['+ (typeof arguments[0].module || arguments[0].toString()).toUpperCase() +'](' + arguments[0].identifier.toString() + '...)';
	   }
	   loadTxt.text('loading ' + str );
       loadTxt.toggle();
       ((!!webfan && 'function'===webfan.\$Async)?webfan.\$Async:setTimeout)(function(){
       	 loadTxt.toggle();
       	 
         ((!!webfan && 'function'===webfan.\$Async)?webfan.\$Async:setTimeout)(function(){
       	    loadTxt.show();
         },1500);       	 
       	 
       },1000);
});


	    
	    




//frdl.main available 
frdl.require.state.once('resolved frdl.main', function(){
  var main = arguments[0].module;
  
 	main.dependency.add('module \$frdl.inX loaded');
    main.dependency.add('module \$webfan/navigator/simpledialog loaded');
    main.dependency.add('module \$frdl.\$DB loaded');	
    
    main.dependency.add('module \$frdl.Hash loaded');	


	main.dependency.add('module \$frdl.UI.progress loaded'); 
  
    main.dependency.add('preload db widgets'); 
    
    
    //    main.dependency.add('module \$filer');	

});   

frdl.require.state.once('resolved frdl.UI', function(){
  var UI = arguments[0].module;
  
  
  
  webfan.\$Async(function(){
    loadTxt = null;
    checkForErrors();	
  },500);
 
  	
     UI.emitter.once('dependency.resolved', function(){
       ((!!webfan && 'function'===webfan.\$Async)?webfan.\$Async:setTimeout)(function(){	 
          frdl.require('http://frdl.webfan.de/cdn/application/webfan/locale/locales-inx.js', function(dictonary){
              frdl.ready(frdl.inX.translate);
          });  
       },500); 
       
    });	
	

   UI.emitter.once('dependency.resolved', function(){
      setTimeout(function(){		   
       webfan.\$Async(function(){
        frdl.require('webfan/my-webfan', function(App){
          frdl.ready(p.complete);
        });
       },30);
      },1);
  });	
  
});   






frdl.require.state.once('resolved frdl.UI.progress', function(){
  p = frdl.UI.progress();	
  p.start();
  setTimeout(function(){
  	  p.stop(false);
     setTimeout(function(){
  	   p.resume();
     }, 1000); 
      webfan.\$Async(function(){
       setTimeout(function(){	
  	     p.complete();
  	  }, 3000);  
     }, 2000); 
  }, 250);
}); 

 
 
frdl.require.state.once('resolved frdl.UI.progress', function(){
  frdl.require('webfan/my-webfan-preloads', function(DummyShouldBeTrueSoFar){

  });
});      
   
   
   


 
 
frdl.require.state.once('resolved webfan/navigator/simpledialog', function(){
  webfan.\$Async(function(){
	frdl.alert.log('<span>BETAVERSION</span> <span>PREVIEW</span>', 'error', /*6000*/60000);
  },250); 
});

 
}());
}());
</script>




</head>
<body>
<p><span webfan-fadeout="7000"><span style="color:red;">loading</span>... This may take a <strong>few minutes</strong> for the first time!</span></p>
<div frdl-mod="fromServer">
 $_htmls
</div>

<div frdl-mod="fromServerToStateFrame" style="display:none;"> 
 $_htmls_state
</div>

<div data-frdl-component="http://example.com/helper/webkit"></div>

<!--
<div data-frdl-component="widget://example.com/webfan/queue"></div>

 	      	 
 	      	 <script type="text/javascript">
 	      	 (function _load(){
 	      	  if(!frdl || !frdl.lang){
			   setTimeout(function(){
 	      	  	 _load();
 	      	  },100);
 	      	   return;
 	      	  }
 	      	   frdl.wd(false).hide();
 	      	 }()); 
 	      	 </script>
-->
</body>
</html>

HTML;


$dummy__ = null;


--3333EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$HOME/method.post.php";name="apc method.post.php"


  
  <?php

/*
\frdl\webfan\App::God(false)->apcHTML('Test: <pre>'.print_r($this->Request->request,true).'</pre>');
*/


/* @todo */
if(isset($this->Request->request['login'])){
	foreach($this->Context->apc->config->admin as $i => $user){
		if($user['user'] !== $this->Request->request['PIN'])continue;
		if(is_string($user['pass']['sha1'])){
			if($user['pass']['sha1'] === sha1($this->Request->request['password'])){
				\frdl\webfan\App::God(false)->session('user', $user); 

			}
		}
	}
}

if(isset($this->Request->request['logout']) && 'logout' === $this->Request->request['logout']){
	\frdl\webfan\App::God(false)->session('user', null); 	
}


if(isset($this->Request->request['install'])){
  $Installer = new \webfan\InstallShield\apc\i1($this);	
  $Installer->install($this->Context->apc->config, $this->Request->request['install_op']);  
}	


//config_dirs

if(isset($this->Request->request['config_dirs']) && \frdl\webfan\App::God(false)->apcIsAdmin()){
 $this->Context->apc->config->config_source['install'] = (isset($this->Request->request['config_source__install'])) ? true : false;
 $this->Context->apc->config->config_source['dir_lib'] = $this->Request->request['config_source__dir_lib'];
 $this->Context->apc->config->config_source['dir_apc'] = $this->Request->request['dir_apc'];
 $this->Context->apc->config->config_source['dir_projects'] = $this->Request->request['dir_projects'];
 $this->Context->apc->config->config_source['dir_apc_bootstrap'] = $this->Request->request['dir_apc_bootstrap'];
 $this->Context->apc->config->config_source['dir_web'] = $this->Request->request['dir_web'];
 $this->Context->apc->config->config_source['dir_packages'] = $this->Request->request['dir_packages'];
 $this->Context->apc->config->config_source['dir_Psr4'] = $this->Request->request['dir_Psr4'];
 $this->Context->apc->config->config_source['dir_Psr0'] = $this->Request->request['dir_Psr0'];
 \frdl\apc\Helper::saveConfig($this, true);
 
}




--3333EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$HOME/Helper.php";name="class frdl\apc\Helper"


  
  <?php
namespace frdl\apc;


class Helper
{
	
	public static function adminMenu_1( $validate = true){


				
		if(true === $validate){
			if(!\frdl\webfan\App::God(false)->apcIsAdmin()){
				return;
			}
		}	
		
        $user = \frdl\webfan\App::God(false)->session('user');
		
		

		
		
		$NavLeft = '';
		$NavLeft .= '<span><span>Hello</span> <strong><a ui-sref="apc.config({ })" ui-sref-opts="{reload: false}">'.$user['user'].'</a></strong></span>';
	      $NavLeft .= '&nbsp;';
		$NavLeft .= '<form action="'.\frdl\webfan\App::God(false)->apc_api_client_url().'" method="post" style="display:inline;" />';
		$NavLeft .= '<a href="javascript:;" onclick="this.parentNode.submit();" style="color:red;">Logout</a>';
		$NavLeft .= '<input type="hidden" name="logout" value="logout" />';
		$NavLeft .= '</form>';
		
		
		\frdl\webfan\App::God(false)->apcDestMessage($NavLeft, 'NavLeft');		
		
		
	 \frdl\webfan\App::God(false)->apcDestMessage( 
		 '<a ui-sref="apc.config({ })"  ui-sref-opts="{reload: false}">'
		 . \frdl\webfan\App::God(false)->apc_api_client_url()
		 . '</a>'
	  , 'apc.projects.project apc 1.2.x');	
		
		$html= '';
		
		
		return $html;
	}
	
	
	public static function saveConfig(&$vm = null, $checkAdmin = true ){
		
		if(true === $checkAdmin && !\frdl\webfan\App::God(false)->apcIsAdmin()){
			\frdl\webfan\App::God(false)->apcWarn('You are not allowed to write to config!');
			return;
		}
		
		
		 if(null === $vm)$vm = \frdl\webfan\App::God(false)->vm();


         $configStr = str_replace(array("stdClass::__set_state", 'o::__set_state', '\o::__set_state', 'O::__set_state', '\O::__set_state'), 
                               array("(object)", "(object)", "(object)", "(object)", "(object)"), 
                               var_export($vm->context->apc->config, true));		 
		 
		 $version_installer = $vm->context->apc->config->version_installer;
		 
		 
		 $newCode = <<<PHP
		 
<?php



\$this->Context->apc = new \O;

\$this->Context->apc->config = $configStr;

\$this->Context->apc->config->version_installer='$version_installer';

		 
PHP;
		 
      $configFile = $vm->get_file($vm->document, '$HOME/apc_config.php', 'stub apc_config.php')
            ->setBody($newCode)
          ;  


        self::save($vm, $checkAdmin);
	}
	
	
	public static function save($vm = null , $checkAdmin = true ){
		if(true === $checkAdmin && !\frdl\webfan\App::God(false)->apcIsAdmin()){
			\frdl\webfan\App::God(false)->apcWarn('You are not allowed to write to config!');
			return;
		}	
		
			
		if(null === $vm)$vm = \frdl\webfan\App::God(false)->vm();
		
	
		
        $vm->location = $vm->location;
	}	
		
}

--3333EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: httpd ;filename="$HOME/$WEBprepare.php";name="$WEB prepare.php"


  
  <?php


if(isset($_GET['format']) && 'html' === $_GET['format']){
 ob_start(function($c){
	
 $c= '<pre>'.$c.'</pre>';
   return $c;	
 });	
}else{
	header('Content-Type: text/plain');
}



if(!\frdl\webfan\App::God(false)->apcIsAdmin()){
\webdof\wResponse::status(401);	
  die('You have to login!'.PHP_EOL);	
}



echo "Make directories".PHP_EOL;
$dirs = array();

$tok = 'dir_';
foreach($this->Context->apc->config->config_source as $k => $v){
	if($tok === substr($k, 0, strlen($tok))){
		array_push($dirs, $v);
	}
}	
array_push($dirs, $this->Context->apc->config->config_source['dir_apc_bootstrap'].'inc');


foreach($dirs as $dir){
 if(!is_dir($dir))mkdir($dir, 0755, true);
 if(!is_dir($dir)){
	echo 'Failed to create '.$dir.PHP_EOL;
 }else{
	echo $dir." created".PHP_EOL;
 }  
 
 chmod($dir, 0755);
}

echo PHP_EOL;
echo "Extract bootstrap files:".PHP_EOL;

$files = array(
   array('$DIR_PSR4/O.php', 'class O', 'O.php'),
   array('$DIR_LIB/frdl/A.php', 'class frdl\A', 'A.php'),
   array('$DIR_LIB/frdl/webfan/App.php', 'class frdl\webfan\App', 'App.php'),
   array('$DIR_LIB/frdl/common/Stream.php', 'class frdl\common\Stream', 'Stream.php'),
   array('$DIR_LIB/frdl/webfan/Autoloading/Loader.php', 'class frdl\webfan\Autoloading\Loader', 'Loader.php'),
   array('$DIR_LIB/frdl/webfan/Autoloading/SourceLoader.php', 'class frdl\webfan\Autoloading\SourceLoader', 'SourceLoader.php'),
   array('$DIR_LIB/frdl/webfan/Autoloading/Autoloader.php', 'class frdl\webfan\Autoloading\Autoloader', 'Autoloader.php'),


);


$b = '<?php';
$b.=PHP_EOL;
$b.="/* include this on top of every project or entry point! */".PHP_EOL;

foreach($files as $file){
  $fp = $this->Context->apc->config->config_source['dir_apc_bootstrap'].'inc'.DIRECTORY_SEPARATOR.$file[2];	
  $f = $this->get_file($this->document, $file[0], $file[1]);
  file_put_contents($fp, $f->getBody());
  if(file_exists($fp)){
  		echo $fp." created".PHP_EOL;
  }else{
  	    echo 'Failed to create '.$fp.PHP_EOL;
  }
  
  $b.='include __DIR__.DIRECTORY_SEPARATOR.\'inc\'.DIRECTORY_SEPARATOR.\''.basename($fp).'\';'.PHP_EOL;
}



echo "Create bootstrap file:".PHP_EOL;

$psr4dir = $this->Context->apc->config->config_source['dir_Psr4'];
$psr0dir = $this->Context->apc->config->config_source['dir_Psr0'];

$b.=<<<PHP

\\frdl\webfan\Autoloading\SourceLoader::repository('frdl'); 

\\frdl\webfan\App::God(true, 'frdl\webfan\Autoloading\Autoloader','AC boot') 

;


  \\frdl\webfan\Autoloading\SourceLoader::top()
       ->addPsr4('\\\', '$psr4dir', false)  
       ->addPsr0('\\\', '$psr0dir', false)  
 ;   

PHP;


file_put_contents($this->Context->apc->config->config_source['dir_apc_bootstrap'].'bootstrap.php', $b);

  if(file_exists($this->Context->apc->config->config_source['dir_apc_bootstrap'].'bootstrap.php')){
  		echo $this->Context->apc->config->config_source['dir_apc_bootstrap'].'bootstrap.php'." created".PHP_EOL;
  }else{
  	    echo 'Failed to create '.$this->Context->apc->config->config_source['dir_apc_bootstrap'].'bootstrap.php'.PHP_EOL;
  }


echo "Download APC:".PHP_EOL;


    	$opts = array(
    	  'method'=>'GET',
    	  'user_agent'=>'Webfan.de APC@'.\frdl\webfan\App::God(false)->apc_api_client_url(),
    	  'referer'=>\frdl\webfan\App::God(false)->apc_api_client_url(),
    	  'debug'=>0,
    	  'html_debug'=>0,
    	  'follow_redirect'=>1,
    	);
    	
    	$url = 'https://github.com/frdl/webfan/archive/master.zip';
    	
    	$http = new \webdof\wHTTP();
         $http->debug=$opts['debug'];
        $http->html_debug=$opts['html_debug'];
        $http->follow_redirect=$opts['follow_redirect'];
       //  $http->user_agent = $_SERVER['HTTP_USE_AGENT'];   
        $http->user_agent =$opts['user_agent'];
      //   $arguments['Headers']['Referer']= $_SERVER['HTTP_REFERER'];	
        $arguments['Headers']['Referer']= $opts['referer'];
        
        $error=$http->GetRequestArguments($url,$arguments);

        if($error)echo $error;

        $error=$http->Open($arguments);


       $arguments['Headers']['X-Forwarded-For']=  $_SERVER['REMOTE_ADDR'];  
        $arguments['Headers']['X-frdl-proxy']= \frdl\webfan\App::God(false)->apc_api_client_url();  
          $arguments['Headers']['X-frdl-github-app-page']=  'http://frdl.github.io/webfan/';  
        $arguments['RequestMethod']=$opts['method'];
        if(empty($error))$error=$http->SendRequest($arguments);  	

        if(empty($error))$error=$http->ReadReplyHeaders($headers);

        if(empty($error))$error = $http->ReadWholeReplyBody($zipData);   
       
        if($error)echo $error.PHP_EOL;   	
    	
    if(empty($error) && !empty($zipData)){
    	echo 'Downloaded.'.PHP_EOL;   	
    	echo 'unzip...'.PHP_EOL;   	
    	$zipfile = $this->context->apc->config->config_source['dir_apc'].'apc.zip';
    	file_put_contents($zipfile, $zipData);
		$wUnzip = new \frdl\webfan\Compress\zip\wUnzip($zipfile, $this->context->apc->config->config_source['dir_apc']);
		$wUnzip->load($zipfile, $this->context->apc->config->config_source['dir_apc']);
		$wUnzip->unzip();
		echo 'end'.PHP_EOL;   
	}else{
		echo "Cannot download APC".PHP_EOL;   	
	}	
--3333EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: httpd ;filename="$HOME/$WEBinfo.php";name="$WEB info.php"


  
  <?php
namespace frdl\apc\info;

if(!\frdl\webfan\App::God(false)->apcIsAdmin()){
\webdof\wResponse::status(401);	
  die('You have to login!'.PHP_EOL);	
}

function parsePHPModules() {
ob_start();
phpinfo(INFO_MODULES);
$s = ob_get_contents();
ob_end_clean();

$s = strip_tags($s,'<h2><th><td>');
$s = preg_replace('/<th[^>]*>([^<]+)<\/th>/',"<info>\\1</info>",$s);
$s = preg_replace('/<td[^>]*>([^<]+)<\/td>/',"<info>\\1</info>",$s);
$vTmp = preg_split('/(<h2>[^<]+<\/h2>)/',$s,-1,PREG_SPLIT_DELIM_CAPTURE);
$vModules = array();
for ($i=1;$i<count($vTmp);$i++) {
  if (preg_match('/<h2>([^<]+)<\/h2>/',$vTmp[$i],$vMat)) {
   $vName = trim($vMat[1]);
   $vTmp2 = explode("\n",$vTmp[$i+1]);
   foreach ($vTmp2 AS $vOne) {
    $vPat = '<info>([^<]+)<\/info>';
    $vPat3 = "/$vPat\s*$vPat\s*$vPat/";
    $vPat2 = "/$vPat\s*$vPat/";
    if (preg_match($vPat3,$vOne,$vMat)) { // 3cols
     $vModules[$vName][trim($vMat[1])] = array(trim($vMat[2]),trim($vMat[3]));
    } elseif (preg_match($vPat2,$vOne,$vMat)) { // 2cols
     $vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
    }
   }
  }
}
return $vModules;
} 

$info = new \O;
$info->PHP_OS = PHP_OS;
$info->PHP_VERSION = PHP_VERSION;
$info->PHP_SAPI = PHP_SAPI;
$info->extensions = new \O;
foreach(\get_loaded_extensions() as $ext){
	$info->extensions->{$ext} = phpversion($ext);
	
}


header('Content-Type: application/json');
echo json_encode($info);



--3333EVGuDPPT
Content-Type: application/x-httpd-php;charset=utf-8
Content-Disposition: php ;filename="$DIR_LIB/webdof/wResponse.php";name="class webdof\wResponse"




<?php  
namespace webdof;

class wResponse
{


  public static function header($name, $value)
    {
       return header($name.': '.$value);
    }



  public static function status($code = 200)
    {
       if((int)$code == 200)return header('HTTP/1.1 200 Ok');
       if((int)$code == 201)return header('HTTP/1.1 201 Created');
       if((int)$code == 304)return header('HTTP/1.1 304 Not Modified');
       if((int)$code == 400)return header("HTTP/1.1 400 Bad Request");
       if((int)$code == 401)return header('HTTP/1.1 401 Unauthorized');
       if((int)$code == 403)return header("HTTP/1.1 403 Forbidden");
       if((int)$code == 404)return header("HTTP/1.1 404 Not Found");
       if((int)$code == 409)return header('HTTP/1.1 409 Conflict');

       if((int)$code == 455)return header('HTTP/1.1 455 Blocked Due To Misbehavior');

       if((int)$code == 500)return header("HTTP/1.1 500 Internal Server Error");
       if((int)$code == 501)return header('HTTP/1.1 501 Not Implemented');
	   if(defined('mxMainFileLoaded') && version_compare(PMX_VERSION, '2.1.2', '>=') === TRUE )\pmxHeader::Status($code);
       trigger_error('status code '.intval($code).' not implemented in \'' . get_class($this) . '\'   ' . __METHOD__. ' '.__LINE__, E_USER_ERROR);
    }




}

--3333EVGuDPPT
Content-Type: application/manifest+json;charset=utf-8
Content-Disposition: httpd ;filename="$HOME/$WEBmanifest.webapp";name="$WEB manifest.webapp"


  
  {"id":"frdl.my.webfan.v1.2.0.0.1487610230.4776","short_name":"Webfan SDK InstallShield","installOrigin":"http:\/\/www.webfan.de\/install\/","external":true,"installs_allowed_from":["http:\/\/www.webfan.de\/install\/"],"related_applications":[{"platform":"webfan","url":"http:\/\/domainundhomepagespeicher.webfan.de\/shop\/webfan-application-composer.255.html","id":"frdl.my.webfan.v1.2.0.0.1487610230.4776"}],"version":"1.2.0.0.1487610230.4776","release_notes":"Pre-Beta release","description":"Application Comoposer Application","developer":{"name":"Till Wehowski","url":"http:\/\/frdl.webfan.de"},"icons":[{"src":"icons\/icon16x16.ico","sizes":"16x16"},{"src":"http:\/\/www.webfan.de\/modules\/Sitebanner\/images\/wy_88x31.gif","sizes":"88x31"},{"src":"http:\/\/static.webfan.de\/site_gadgets\/icon128x128.ico","sizes":"128x128"}],"type":"web","permissions":{"systemXHR":{"description":"Required to load remote content"}},"default_locale":"en","chrome":{"navigation":true},"display":"browser","orientation":"landscape","receipts":[]}
--3333EVGuDPPT
Content-Type: image/x-icon
Content-Disposition: httpd ;filename="$HOME/$WEB/images/apc.ico";name="$WEB /images/apc.ico"




-/Fyyy>X\`eCJR8B^yy[]qO
3vyyyyyyyyyyv;*vyyyyyyyyyyyyyUnyyyyyyyÿÿ
--3333EVGuDPPT
Content-Type: text/plain
Content-Disposition: httpd ;filename="$HOME/$CNF/JWT/1.3.6.1.4.1.37553.8.1.8.2.2:pwd/0/computed/handshake/apc/1.2.0";name="JWT /pwd/0/computed/handshake/apc/1.2.0"



eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiIsImtpZCI6IjEuMy42LjEuNC4xLjM3NTUzLjguMS44LjIuMjpwd2RcLzBcL2NvbXB1dGVkXC9oYW5kc2hha2VcL2FwY1wvMS4yLjAifQ.eyJleHAiOjI0MzM2OTAyMzAsImlzcyI6IjEuMy42LjEuNC4xLjM3NTUzLjguMS44LjgiLCJhdWQiOiJhcGNAbG9jYWxob3N0IiwidHlwZSI6InVybjpvaWQ6MS4zLjYuMS40LjEuMzc1NTMuOC4xLjguMi4yOlwvcHdkXC8wXC9jb21wdXRlZFwvaGFuZHNoYWtlXC9hcGNcLzEuMi4wIiwicGFja2FnZSI6ImZyZGxcL3dlYmZhbiIsInZlcnNpb24iOiIxLjIuMC4wLjE0ODc2MTAyMzAuNDc3NiIsIm9pZCI6IjEuMy42LjEuNC4xLjM3NTUzLjguMS44LjguNS42NSIsImRsdGltZSI6MTQ4NzYxMDIzMCwiaXRpbWUiOmZhbHNlLCJpcGluIjpmYWxzZSwidWlkIjowLCJ1c2VybmFtZSI6IkBhbm9ueW1vdXMiLCJlbWFpbCI6ZmFsc2UsImxrZXkiOmZhbHNlLCJscyI6ZmFsc2UsImtzMTIwIjoic3koP2oueHt3LUJ2Ql56WFpDWmM9TS4-YF9FSyE9cHR6W3ZUZVIhe0hMWGlETEpzWylyNm0ral9cL3lIO05xZi5bPnR5LGQ8VSZ-aH0sLkxIV0ZlfXQlc25HelFeNGRaej09PylNMV9DdTQwTG5RRH5iMXY8UTxLdVZVcXl9Z2ZpXVNoQkdnfXtxdDZWSG84NDglT2x1SE8rVCwmfW1KdDtqaHMsTVFBVUF7SFZUXC8hNGtmbGtMMDtKWT1ob1c-OXkkSkxmXk00M0hlKGRBKHsqYGtpLmhaLXVIKmE1N2wsWl1yP2Q2NG8yLVNFWltmMUc3WSR3TGNfSGRjX01tTzlJIiwia3IxMjAiOiJafiFsN2c6bi1KVjR0SW4-RDg2XVl-aykqQzEhenBaWUl5YmxVWFckekIkISoubGI_SmEuNUMuP1JkaC45SyVeRWtBV0YyUGhHXi1xdEtjSCgrQVlYST9NU3MmS2c2fTw6fmRtVlFISmlZcHxyXC9-MkZYOlkyPDc7XjtnTHpzLW9vN3tDbG1iMy5VdllMXUxOKHF0LUYsQikwMXgxIVwvTFJJRHo0TWMuPE1IW3o3eDpnQjtMXX18OX5qcSVRLHNROShpV3ZaNih5ZjhtX2lmS2I9Qz10U0doaDlINEVxWnA0M11ycH47eTUhJGZOKG15b0J6M0JoanNHYmYsVG5JQykiLCJrYzEyMCI6ImUwNTkzMTY4MjAwMmQ5ZDM4YzM3NzgyY2NjNGRjYTE4Yjg1YTg5ZGYifQ.TYSzOoenqUAZs-27Wx7tH93-Gmi2j65ceLxjZF_8lok
--3333EVGuDPPT--
--hoHoBundary12344dh--
