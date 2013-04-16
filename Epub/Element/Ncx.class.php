<?php
/**
 * ncx文件，电子书的目录
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Ncx extends Epub_Element
{
	private $navMap = array(
		/*
		array(
			'id' => '0',
			'playOrder' => '0', //default self index
			'text' => 'default text',
			'src' => '', //html src
		),
		*/
	);

	private $docTitle = 'Default';
	private $docAuthor = 'Default';

	public function __construct(){
		$this->file = 'bdoc.ncx';
		$this->type = 'xml';
	}

	public function setTitle($title){
		$this->docTitle = $title;
	}

	public function setAuthor($author){
		$this->docAuthor = $author;
	}

	/**
	 * 增加导航内容
	 *
	 * 必须为：Epub_Element_Ncx_Nav对象
	 *
	 * @param Epub_Element_Ncx_Nav $nav
	 */
	public function addNav(Epub_Element_Ncx_Nav $nav){
		$this->navMap[] = $nav;
	}

	public function getString(){
		$this->clearString();
		//doctype section
		$this->addString('<!DOCTYPE ncx PUBLIC "-//NISO//DTD ncx 2005-1//EN" "http://www.daisy.org/z3986/2005/ncx-2005-1.dtd">');
		$this->addString('<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1" xml:lang="cn">');
		//meta section
		$this->addString('<head>');
		/**
		 * <meta name="dtb:uid" content="http://JohnJaneDoePublications.com/books/TestBook.html" />
		 * <meta name="dtb:depth" content="2" />
		 * <meta name="dtb:totalPageCount" content="0" />
		 * <meta name="dtb:maxPageNumber" content="0" />
		 * <meta name="dtb:generator" content="EPub (2.11) by A. Grandt, http://www.phpclasses.org/package/6115" />
		 */
		$this->addString('<meta name="dtb:uid" content="" />');
		$this->addString('<meta name="dtb:depth" content="2" />');
		$this->addString('<meta name="dtb:totalPageCount" content="0" />');
		$this->addString('<meta name="dtb:maxPageNumber" content="0" />');
		$this->addString('<meta name="dtb:generator" content="PHPEpub (v0.1) alpha, https://github.com/monkee/phpepub" />');
		$this->addString('</head>');
		//docTitle & docAuthor
		$this->addString(sprintf('<docTitle><text>%s<text></docTitle>', $this->docTitle));
		$this->addString(sprintf('<docAuthor><text>%s<text></docAuthor>', $this->docAuthor));
		//navmap section
		$this->addString('<navMap>');
		foreach($this->navMap as $i => $nav){
			$string = sprintf('<navPoint id="%s" playOrder="%d"><navLabel><text>%s</text></navLabel><content src="%s" /></navPoint>',
				$nav->id, $nav->playOrder, $nav->text, $nav->src);
			$this->addString($string);
		}
		$this->addString('</navMap>');

		//end
		$this->addString('</ncx>');

		return $this->string;
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */