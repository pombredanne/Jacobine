<?php
/**
 * This file is part of the TYPO3-Analytics package.
 *
 * (c) Andreas Grunwald <andygrunwald@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TYPO3Analysis\Tests\Consumer\Analysis;

use TYPO3Analysis\Tests\Consumer\ConsumerTestAbstract;
use TYPO3Analysis\Consumer\Analysis\PHPLoc;

/**
 * Class PHPLocTest
 *
 * Unit test class for \TYPO3Analysis\Consumer\Analysis\PHPLoc
 *
 * @package TYPO3Analysis\Tests\Consumer\Analysis
 * @author Andy Grunwald <andygrunwald@gmail.com>
 */
class PHPLocTest extends ConsumerTestAbstract
{

    public function setUp()
    {
        $this->consumer = new PHPLoc();
    }
}