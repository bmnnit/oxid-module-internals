<?php
/**
 * Module internals tools data helper tests.
 *
 * @author Alfonsas Cirtautas
 *
 * @covers ac_module_internals_data_helper
 */
class ac_module_internals_data_helperTest extends PHPUnit_Framework_TestCase {

    public function testGetModule()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModule(), $oModule);
    }

    public function testSetModule()
    {
        $oModule = $this->getMock('oxmodule', array('isCustom'));
        $oModule->method('isCustom')->willReturn(false);

        $oCustomModule = $this->getMock('oxmodule', array('isCustom'));
        $oCustomModule->method('isCustom')->willReturn(true);

        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setModule($oCustomModule);

        $this->assertTrue($helper->getModule()->isCustom());
    }

    public function testGetModuleList()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleList(), $oModuleList);
    }

    public function testSetModuleList()
    {
        $oModule = $this->getMock('oxmodule');

        $oModuleList = $this->getMock('oxmodulelist', array('isCustom'));
        $oModuleList->method('isCustom')->willReturn(false);

        $oCustomModuleList = $this->getMock('oxmodulelist', array('isCustom'));
        $oCustomModuleList->method('isCustom')->willReturn(true);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setModuleList($oCustomModuleList);

        $this->assertTrue($helper->getModuleList()->isCustom());
    }

    public function testSetGetConfig()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxconfig');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setConfig($oConfig);

        $this->assertEquals($helper->getConfig(), $oConfig);
    }

    public function testSetGetDb()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $oDb = $this->getMock('oxLegacyDb');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $helper->setDb($oDb);

        $this->assertEquals($helper->getDb(), $oDb);
    }

    public function testGetInfo()
    {
        $oModule = $this->getMock('oxmodule', array('getInfo'));
        $oModule->method('getInfo')->willReturn('info');

        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getInfo('id'), 'info');
    }

    public function testGetModuleBlocks()
    {
        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxConfig', array('getShopId'));
        $oConfig->method('getShopId')->willReturn('shop-id');

        $oDb = $this->getMock('oxLegacyDb', array('getAll'));
        $oDb->expects($this->any())
            ->method('getAll')
            ->with($this->anything(), $this->equalTo( array('module-id','shop-id')))
            ->willReturn('module-themes');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);
        $helper->setConfig($oConfig);
        $helper->setDb($oDb);

        $this->assertEquals($helper->getModuleBlocks(), 'module-themes');
    }

    public function testGetModuleSettings()
    {
        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxConfig', array('getShopId'));
        $oConfig->method('getShopId')->willReturn('shop-id');

        $oDb = $this->getMock('oxLegacyDb', array('getAll'));
        $oDb->expects($this->any())
            ->method('getAll')
            ->with($this->anything(), $this->equalTo( array('module-id','shop-id')))
            ->willReturn('module-settings');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);
        $helper->setConfig($oConfig);
        $helper->setDb($oDb);

        $this->assertEquals($helper->getModuleSettings(), 'module-settings');
    }

    public function testGetModuleFiles()
    {
        $aAllModuleFiles = array(
            'module-id'         => array( 'file1', 'file2'),
            'another-module-id' => array( 'file3', 'file4'),
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleFiles'));
        $oModuleList->method('getModuleFiles')->willReturn($aAllModuleFiles);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleFiles(), $aAllModuleFiles['module-id']);
    }

    public function testGetModuleTemplates()
    {
        $aAllModuleTemplates = array(
            'module-id'         => array( 'template1', 'template2'),
            'another-module-id' => array( 'template3', 'template4'),
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleTemplates'));
        $oModuleList->method('getModuleTemplates')->willReturn($aAllModuleTemplates);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleTemplates(), $aAllModuleTemplates['module-id']);
    }

    public function testGetModuleEvents()
    {
        $aAllModuleEvents = array(
            'module-id'         => array( 'event1', 'event2'),
            'another-module-id' => array( 'event3', 'event4'),
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleEvents'));
        $oModuleList->method('getModuleEvents')->willReturn($aAllModuleEvents);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleEvents(), $aAllModuleEvents['module-id']);
    }

    public function testGetModuleVersion()
    {
        $aAllModuleVersions = array(
            'module-id'         => 'version1',
            'another-module-id' => 'version2',
        );

        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist', array('getModuleVersions'));
        $oModuleList->method('getModuleVersions')->willReturn($aAllModuleVersions);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleVersion(), $aAllModuleVersions['module-id']);
    }

    public function testIsMetadataSupportedFirstRelease()
    {
        $oModule     = $this->getMock('oxmodule');
        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertTrue($helper->isMetadataSupported('0.1'));
        $this->assertTrue($helper->isMetadataSupported('1.0'));

        $this->assertFalse($helper->isMetadataSupported('1.1'));
    }

    public function testIsMetadataSupportedSecondRelease()
    {
        $oModule     = $this->getMock('oxmodule', array('getModuleEvents'));
        $oModuleList = $this->getMock('oxmodulelist', array('getModuleVersions'));

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertTrue($helper->isMetadataSupported('0.1'));
        $this->assertTrue($helper->isMetadataSupported('1.0'));
        $this->assertTrue($helper->isMetadataSupported('1.1'));

        $this->assertFalse($helper->isMetadataSupported('1.2'));
    }

    public function testGetModulePath()
    {
        $oModule = $this->getMock('oxmodule', array('getId', 'getModulePath'));
        $oModule->method('getId')->willReturn('module-id');

        $oModule->expects($this->any())
                ->method('getModulePath')
                ->with($this->equalTo('module-id'))
                ->willReturn('module-id-path');

        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModulePath(), 'module-id-path');
    }

    public function testGetModuleId()
    {
        $oModule = $this->getMock('oxmodule', array('getId'));
        $oModule->method('getId')->willReturn('module-id');

        $oModuleList = $this->getMock('oxmodulelist');

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);

        $this->assertEquals($helper->getModuleId(), 'module-id');
    }

    public function testCheckExtendedClassesOK()
    {
        $ModuleId  = 'module-id';
        $ModulePath = '';
        $ModuleExtend = array('shop-class'=>'module-class');

        $GlobalExtend = array('shop-class'=>array('module-class'));
        $ModulesDir = __DIR__.'/data/';

        $expectedResults = array('shop-class'=>array('module-class' => ac_module_internals_data_helper::STATE_OK));

        $oModule = $this->getMock('oxmodule', array('getId', 'getModulePath', 'getInfo'));
        $oModule->method('getId')->willReturn($ModuleId);
        $oModule->method('getModulePath')->willReturn($ModulePath);
        $oModule->method('getInfo')->with($this->equalTo('extend'))->willReturn($ModuleExtend);

        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxConfig', array('getModulesWithExtendedClass', 'getModulesDir'));
        $oConfig->method('getModulesWithExtendedClass')->willReturn($GlobalExtend);
        $oConfig->method('getModulesDir')->willReturn($ModulesDir);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);
        $helper->setConfig($oConfig);

        $checkResults  = $helper->checkExtendedClasses();

        $this->assertEquals($expectedResults, $checkResults);
    }

    public function testCheckExtendedClassesNotInstalled()
    {
        $ModuleId  = 'module-id';
        $ModulePath = '';
        $ModuleExtend = array('shop-class'=>'module-class');

        $GlobalExtend = array();
        $ModulesDir = __DIR__.'/data/';

        $expectedResults = array('shop-class'=>array('module-class' => ac_module_internals_data_helper::STATE_WARNING));

        $oModule = $this->getMock('oxmodule', array('getId', 'getModulePath', 'getInfo'));
        $oModule->method('getId')->willReturn($ModuleId);
        $oModule->method('getModulePath')->willReturn($ModulePath);
        $oModule->method('getInfo')->with($this->equalTo('extend'))->willReturn($ModuleExtend);

        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxConfig', array('getModulesWithExtendedClass', 'getModulesDir'));
        $oConfig->method('getModulesWithExtendedClass')->willReturn($GlobalExtend);
        $oConfig->method('getModulesDir')->willReturn($ModulesDir);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);
        $helper->setConfig($oConfig);

        $checkResults  = $helper->checkExtendedClasses();

        $this->assertEquals($expectedResults, $checkResults);
    }

    public function testCheckExtendedClassesNotFound()
    {
        $ModuleId  = 'module-id';
        $ModulePath = '';
        $ModuleExtend = array('shop-class'=>'module-class-not-found');

        $GlobalExtend = array('shop-class'=>array('module-class-not-found'));
        $ModulesDir = __DIR__.'/data/';

        $expectedResults = array('shop-class'=>array('module-class-not-found' => ac_module_internals_data_helper::STATE_FATAL_MODULE));

        $oModule = $this->getMock('oxmodule', array('getId', 'getModulePath', 'getInfo'));
        $oModule->method('getId')->willReturn($ModuleId);
        $oModule->method('getModulePath')->willReturn($ModulePath);
        $oModule->method('getInfo')->with($this->equalTo('extend'))->willReturn($ModuleExtend);

        $oModuleList = $this->getMock('oxmodulelist');

        $oConfig = $this->getMock('oxConfig', array('getModulesWithExtendedClass', 'getModulesDir'));
        $oConfig->method('getModulesWithExtendedClass')->willReturn($GlobalExtend);
        $oConfig->method('getModulesDir')->willReturn($ModulesDir);

        $helper = new ac_module_internals_data_helper($oModule, $oModuleList);
        $helper->setConfig($oConfig);

        $checkResults  = $helper->checkExtendedClasses();

        $this->assertEquals($expectedResults, $checkResults);
    }

}
