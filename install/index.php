<?php

/**
 * Class parfeon_test
 */
class parfeon_test extends \CModule
{
    public $MODULE_ID = 'parfeon.test';

    public $MODULE_VERSION = '1.0.0';

    public $MODULE_VERSION_DATE = '2020-01-27 11:30:00';

    public $MODULE_NAME = 'Тестовое задание';

    public $MODULE_DESCRIPTION = 'Тестовое задание, по REST API';

    public $PARTNER_NAME = 'parfeon';

    public $MODULE_PATH = '/local/modules/parfeon.test';

    public $DOCUMENT_ROOT = '';

    public function __construct()
    {
        $context = \Bitrix\Main\Application::getInstance()->getContext();
        $server = $context->getServer();
        $this->DOCUMENT_ROOT = $server->getDocumentRoot();
    }

    /**
     * Устанавливаем модуль
     */
    public function doInstall()
    {
        $this->installDB();

        \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

        // Регистрируемся на событие OnRestServiceBuildDescription
        \Bitrix\Main\EventManager::getInstance()->registerEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            $this->MODULE_ID,
            '\parfeon\test\Service',
            'getRestMethods'
        );
    }

    /**
     * Удаляем модуль
     */
    public function doUninstall()
    {

        $this->uninstallDB();

        // Отмена регистрации модуля в системе
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

        \Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            $this->MODULE_ID,
            '\parfeon\Test\Service',
            'getRestMethods'
        );
    }

    /**
     * Создаем таблицу в БД
     * @return bool
     */
    public function installDB()
    {
        global $DB, $APPLICATION;

        // db
        $errors = $DB->runSQLBatch(
            $this->DOCUMENT_ROOT . $this->MODULE_PATH . '/install/db/install.sql');
        if ($errors !== false)
        {
            $APPLICATION->throwException(implode('', $errors));
            return false;
        }

        return true;
    }

    /**
     * Удаляем таблицу в БД
     * @return bool
     */
    public function uninstallDB()
    {
        global $DB, $APPLICATION;

        // db
        $errors = $DB->runSQLBatch(
            $this->DOCUMENT_ROOT . $this->MODULE_PATH . '/install/db/uninstall.sql');
        if ($errors !== false)
        {
            $APPLICATION->throwException(implode('', $errors));
            return false;
        }

        return true;
    }
}