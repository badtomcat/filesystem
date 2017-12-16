<?php


use Badtomcat\Filesystem\Condition;
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
        $ret = Filter::filterEndswith(__DIR__."/aaaa",'.js', Condition::create()
            ->setReturnBasename());
        $this->assertArraySubset(["aaa.js"],$ret);
        $ret = Filter::filterEndswith(__DIR__."/aaaa",'.txt',Condition::create()
            ->setExcept(['ba']) ->setReturnBasename(),true);
        $this->assertArraySubset(["a.txt"],$ret);
        $ret = Filter::filterEndswith(__DIR__."/aaaa",'.txt',Condition::create()
            ->setOnly(['ba'])->setReturnFilename(),true);
        $this->assertArraySubset(["ba"],$ret);

        $ret = Filter::getDirectories(__DIR__."/aaaa",Condition::create()
            ->setReturnFilename(),true);
        $this->assertArraySubset(["aaa","bbb","ddd","da"],$ret);

        $ret = Filter::getDirectories(__DIR__."/aaaa",Condition::create()
            ->setReturnFilename());
        $this->assertArraySubset(["aaa","bbb","ddd"],$ret);

	}
}


