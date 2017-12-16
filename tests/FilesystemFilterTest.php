<?php


use Badtomcat\Filesystem\Filter;

class FilesystemFilterTest extends PHPUnit_Framework_TestCase
{
	/**
	* A basic test example.
	*
	* @return void
	*/
	public function testx()
	{
		$ret = Filter::filterRecursive(__DIR__.'/aaaa',function ($path){
		    if (mb_substr($path,-4,4) == ".txt")
		        return true;
        });
        $ret = Filter::filterEndswith(__DIR__."/aaaa",'.js',[
            'return' => 'basename'
        ]);
        $this->assertArraySubset(["aaa.js"],$ret);
        $ret = Filter::filterEndswith(__DIR__."/aaaa",'.txt',[
            'except' => ['ba'],
            'return' => 'basename'
        ],true);
        $this->assertArraySubset(["a.txt"],$ret);
        $ret = Filter::filterEndswith(__DIR__."/aaaa",'.txt',[
            'only' => ['ba'],
            'return' => 'filename'
            ],true);
        $this->assertArraySubset(["ba"],$ret);

        $ret = Filter::filterAllDir(__DIR__."/aaaa",[
            'return' => 'filename'
        ],true);
        $this->assertArraySubset(["aaa","bbb","ddd","da"],$ret);

        $ret = Filter::filterAllDir(__DIR__."/aaaa",[
            'return' => 'filename'
        ]);
        $this->assertArraySubset(["aaa","bbb","ddd"],$ret);

	}
}


