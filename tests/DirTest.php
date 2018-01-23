<?php

use Badtomcat\Filesystem\Filesystem;

class DirTest extends PHPUnit_Framework_TestCase
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
        $dir = new \Badtomcat\Filesystem\Dir(__DIR__);
        $dir->mkdir('dir-test');
        $this->assertFileExists(__dir__ . "/dir-test", "ok");
        $dir->cd('dir-test');
        $this->assertEquals('/dir-test',$dir->getRelativePath());
        $dir->mkdir('examples');
        $this->assertFileExists(__dir__ . "/dir-test/examples", "ok");

        $f = $dir->cd('examples');
        $this->assertTrue($f);

        $dir->mkdir('aa');
        $f = $dir->cd('aa');
        $this->assertTrue($f);

        $dir->touch("qq");
        $this->assertFileExists(__dir__ . "/dir-test/examples/aa/qq", "ok");

        $dir->cd();
        $dir->cd('dir-test');
        $this->assertTrue($dir->copyDir("examples", "balabala"),'copied ok');
        $this->assertFileExists(__dir__ . "/dir-test/balabala/aa/qq", "ok");
//
        //examples
        $dir->cd('examples');
        $dir->cd('aa');
        $dir->copyFile("qq", "exe");
        $this->assertFileExists(__dir__ . "/dir-test/examples/aa/exe");

        $dir->up(2);//   /dir-test
        $dir->mkdir('ba');
        $this->assertTrue($dir->hasDir('ba'));

        $this->assertTrue($dir->delDir("ba"));

        $this->assertTrue($dir->hasDir('balabala'));
        $this->assertTrue($dir->delDir("balabala"));
        $this->assertFileNotExists(__dir__ . "/dir-test/balabala");
        $dir->cd();
        $this->assertTrue($dir->delDir("dir-test"));
    }

}


