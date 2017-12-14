<?php

use Badtomcat\Filesystem\Filesystem;

class FilesystemTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		
	}
	public function tearDown()
	{

	}


	/**
	* A basic test example.
	*
	* @return void
	*/
	public function testx()
	{
		Filesystem::createDir(__dir__."/examples");
		$this->assertFileExists(__dir__."/examples","ok");
		Filesystem::createDir(__dir__."/examples/aa");
		$this->assertFileExists(__dir__."/examples/aa","ok");
		
		Filesystem::touch(__dir__."/examples/aa/qq");
		$this->assertFileExists(__dir__."/examples/aa/qq","ok");
		
		Filesystem::copyDir(__dir__."/examples",__dir__."/balabala");
		$this->assertFileExists(__dir__."/balabala/aa/qq","ok");



        Filesystem::copyDir(__dir__."/examples",__DIR__."/ba",true);
        $this->assertFileExists(__dir__."/ba/examples");
        Filesystem::copyFile(__dir__."/examples/aa/qq",__dir__."/ba/examples/force/exe");
        $this->assertFileExists(__dir__."/ba/examples/force/exe");

        Filesystem::copyFile(__dir__."/examples/aa/qq",__dir__."/ba/examples/notforce/exe",false);
        $this->assertFileNotExists(__dir__."/ba/examples/notforce/exe");

        Filesystem::delDir(__dir__."/ba");

		Filesystem::delDir(__dir__."/balabala");
		$this->assertFileNotExists(__dir__."/balabala");

		Filesystem::delDir(__dir__."/examples",false);
        $this->assertFileExists(__dir__."/examples","ok");

        Filesystem::delDir(__dir__."/examples");

        $this->assertFileNotExists(__dir__."/examples","ok");
	}

}


