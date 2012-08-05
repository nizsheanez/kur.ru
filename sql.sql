-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 04 2012 г., 21:11
-- Версия сервера: 5.1.40
-- Версия PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- БД: `diplom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignments`
--

DROP TABLE IF EXISTS `auth_assignments`;
CREATE TABLE IF NOT EXISTS `auth_assignments` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_assignments`
--

INSERT INTO `auth_assignments` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', 1, NULL, NULL),
('admin', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_items`
--

DROP TABLE IF EXISTS `auth_items`;
CREATE TABLE IF NOT EXISTS `auth_items` (
  `name` varchar(64) NOT NULL COMMENT 'Название',
  `type` int(11) NOT NULL COMMENT 'Тип',
  `description` text COMMENT 'Описание',
  `bizrule` text COMMENT 'Бизнес-правило',
  `data` text COMMENT 'Данные',
  `allow_for_all` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Доступно всем',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_items`
--

INSERT INTO `auth_items` (`name`, `type`, `description`, `bizrule`, `data`, `allow_for_all`) VALUES
('ActionAdmin_Create', 0, 'Добавление мероприятия (админка)', NULL, 'N;', 0),
('ActionAdmin_Delete', 0, 'Удаление мероприятия (админка)', NULL, 'N;', 0),
('ActionAdmin_Manage', 0, 'Управление мероприятиями (админка)', NULL, 'N;', 0),
('ActionAdmin_Update', 0, 'Редактирование мероприятия (админка)', NULL, 'N;', 0),
('ActionAdmin_View', 0, 'Просмотр мероприятия (админка)', NULL, 'N;', 0),
('ActionFileAdmin_Create', 0, 'Добавление файла мероприятия (админка)', NULL, 'N;', 0),
('ActionFileAdmin_Delete', 0, 'Удаление файла мероприятия (админка)', NULL, 'N;', 0),
('ActionFileAdmin_Manage', 0, 'Управление файлами мероприятий (админка)', NULL, 'N;', 0),
('Actions_Admin', 1, 'Управление мероприятиями', '', 's:0:"";', 0),
('Action_Index', 0, 'Просмотр списка мероприятий', NULL, 'N;', 1),
('Action_View', 0, 'Просмотр мероприятия', NULL, 'N;', 1),
('admin', 2, 'Администратор', '', 's:0:"";', 0),
('Admin_Cities_Countries', 1, 'Управление городами и странами', NULL, 's:0:"";', 0),
('Admin_Content', 1, 'Управление контентом', '', 's:0:"";', 0),
('Admin_Documents', 1, 'Управление документами', '', 's:0:"";', 0),
('Admin_Faq', 1, 'Управление вопросами', '', 's:0:"";', 0),
('Admin_Feedback', 1, 'Управление обратной связью', '', 's:0:"";', 0),
('Admin_Languages', 1, 'Управление языками', '', 's:0:"";', 0),
('Admin_Main', 1, 'Админ панель', NULL, 's:0:"";', 0),
('Admin_News', 1, 'Управление новостями', '', 's:0:"";', 0),
('Admin_Pages', 1, 'Редактирование страниц', NULL, 's:0:"";', 0),
('Admin_RBAC', 1, 'Управление контролем доступа', NULL, 's:0:"";', 0),
('Admin_Settings', 1, 'Управление настройками', '', 's:0:"";', 0),
('Admin_Users', 1, 'Управление пользователями', '', 's:0:"";', 0),
('ArticleAdmin_Create', 0, 'Добавление статьи (админка)', NULL, 'N;', 0),
('ArticleAdmin_Delete', 0, 'Удаление статьи (админка)', NULL, 'N;', 0),
('ArticleAdmin_Manage', 0, 'Управление статьями (админка)', NULL, 'N;', 0),
('ArticleAdmin_Update', 0, 'Редактирование статьи (админка)', NULL, 'N;', 0),
('ArticleAdmin_View', 0, 'Просмотр статьи (админка)', NULL, 'N;', 0),
('ArticleSectionAdmin_Create', 0, 'Добавление раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_Delete', 0, 'Удаление раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_GetSectionInSidebar', 0, 'Получить раздел статей, который в сайдбаре (админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_Manage', 0, 'Управление разделами статей(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_Update', 0, 'Редактирование раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_View', 0, 'Просмотр раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSection_GetChilds', 0, 'Получить подразделы статей', '', 's:2:"N;";', 1),
('Articles_Admin', 1, 'Управление статьями', '', 's:0:"";', 0),
('Article_Index', 0, 'Просмотр списка статей', NULL, 'N;', 1),
('Article_Search', 0, 'Поиск статей', NULL, 'N;', 1),
('Article_SectionArticles', 0, 'Просмотр статей раздела', NULL, 'N;', 1),
('Article_View', 0, 'Просмотр статьи', NULL, 'N;', 1),
('BannerAdmin_Create', 0, 'Создание баннера (админка)', NULL, 'N;', 0),
('BannerAdmin_Delete', 0, 'Удаление баннера (админка)', NULL, 'N;', 0),
('BannerAdmin_Manage', 0, 'Управление баннерами (админка)', NULL, 'N;', 0),
('BannerAdmin_Update', 0, 'Редактирование баннера (админка)', NULL, 'N;', 0),
('BannerAdmin_View', 0, 'Просмотр баннера (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Create', 0, 'Создание группы сертификатов (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Delete', 0, 'Удаление группы сертификатов (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Manage', 0, 'Управление группами сертификатов (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Update', 0, 'Редактирование группы сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Create', 0, 'Создание типа сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Delete', 0, 'Удаление типа сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Manage', 0, 'Управление типами сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Update', 0, 'Редактирование типа сертификатов (админка)', NULL, 'N;', 0),
('CityAdmin_Create', 0, 'Добавление города (админка)', NULL, 'N;', 0),
('CityAdmin_Delete', 0, 'Удаление города (админка)', NULL, 'N;', 0),
('CityAdmin_Manage', 0, 'Управление городами (админка)', NULL, 'N;', 0),
('CityAdmin_Update', 0, 'Редактирование города (админка)', NULL, 'N;', 0),
('City_AutoComplete', 0, 'Автодополнение городов', NULL, 'N;', 1),
('CountryAdmin_Create', 0, 'Добавление страны (админка)', NULL, 'N;', 0),
('CountryAdmin_Delete', 0, 'Удаление страны (админка)', NULL, 'N;', 0),
('CountryAdmin_Manage', 0, 'Управление странами (админка)', NULL, 'N;', 0),
('CountryAdmin_Update', 0, 'Редактирование страны (админка)', NULL, 'N;', 0),
('Country_AutoComplete', 0, 'Автодополнение стран', NULL, 'N;', 1),
('DocumentAdmin_Create', 0, 'Добавление документа (админка)', NULL, 'N;', 0),
('DocumentAdmin_Delete', 0, 'Удаление документа (админка)', NULL, 'N;', 0),
('DocumentAdmin_Manage', 0, 'Управление документами (админка)', NULL, 'N;', 0),
('DocumentAdmin_Update', 0, 'Редактирование документа (админка)', NULL, 'N;', 0),
('DocumentAdmin_View', 0, 'Просмотр документа (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Create', 0, 'Добавление файла документа (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Delete', 0, 'Удаление файла документа (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Manage', 0, 'Управление файлами документов (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Update', 0, 'Редактирование файла документа (админка)', NULL, 'N;', 0),
('Document_Index', 0, 'Просмотр списка документов', NULL, 'N;', 1),
('Document_View', 0, 'Просмотр документа', NULL, 'N;', 1),
('FaqAdmin_Create', 0, 'Добавление вопроса (админка)', NULL, 'N;', 0),
('FaqAdmin_Delete', 0, 'Удаление вопроса (админка)', NULL, 'N;', 0),
('FaqAdmin_Manage', 0, 'Управление вопросами (админка)', NULL, 'N;', 0),
('FaqAdmin_Update', 0, 'Редактирование вопроса (админка)', NULL, 'N;', 0),
('FaqAdmin_View', 0, 'Просмотр вопроса (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Create', 0, 'Добавление раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Delete', 0, 'Удаление раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Manage', 0, 'Управление разделами вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Update', 0, 'Редактирование раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_View', 0, 'Просмотр раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSection_Index', 0, 'Просмотр разделов вопросов', NULL, 'N;', 1),
('Faq_Create', 0, 'Добавление вопроса', NULL, 'N;', 1),
('Faq_Index', 0, 'Просмотр списка вопросов', NULL, 'N;', 1),
('FeedbackAdmin_Delete', 0, 'Удаление сообщений (админка)', NULL, 'N;', 0),
('FeedbackAdmin_Manage', 0, 'Управление сообщениями (админка)', NULL, 'N;', 0),
('FeedbackAdmin_View', 0, 'Просмотр сообщений (админка)', NULL, 'N;', 0),
('Feedback_Create', 0, 'Добавление сообщения', NULL, 'N;', 1),
('FileManagerAdmin_Delete', 0, 'Файловый менеджер:Удаление файла (админка)', NULL, 'N;', 0),
('FileManagerAdmin_ExistFiles', 0, 'Файловый менеджер:Загрузка существующих файлов (админка)', NULL, 'N;', 0),
('FileManagerAdmin_Manage', 0, 'Файловый менеджер:Управление файлами (админка)', NULL, 'N;', 0),
('FileManagerAdmin_SavePriority', 0, 'Файловый менеджер:Сортировка (админка)', NULL, 'N;', 0),
('FileManagerAdmin_UpdateAttr', 0, 'Файловый менеджер:Редактирование файла (админка)', NULL, 'N;', 0),
('FileManagerAdmin_Upload', 0, 'Файловый менеджер:Загрузка файлов (админка)', NULL, 'N;', 0),
('FileManager_DownloadFile', 0, 'Файловый менеджер:Скачать файл', NULL, 'N;', 1),
('guest', 2, 'Гость', '', 's:0:"";', 0),
('Help_Captcha', 0, NULL, NULL, NULL, 1),
('Help_Sitemap', 0, NULL, NULL, NULL, 1),
('Help_Sitemapxml', 0, NULL, NULL, NULL, 1),
('LanguageAdmin_Create', 0, 'Добавление языка (админка)', NULL, 'N;', 0),
('LanguageAdmin_Delete', 0, 'Удаление языка (админка)', NULL, 'N;', 0),
('LanguageAdmin_Manage', 0, 'Управление языками (админка)', NULL, 'N;', 0),
('LanguageAdmin_Update', 0, 'Редактирование языка (админка)', NULL, 'N;', 0),
('LogAdmin_View', 0, 'Просмотр логово (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Create', 0, 'Добавление генерируемого поля (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Delete', 0, 'Удаление генерируемого поля (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Manage', 0, 'Управление генерируемыми полями (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Update', 0, 'Редактирование генерируемого поля (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Create', 0, 'Cоздание рассылки (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Delete', 0, 'Удаление рассылки (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Manage', 0, 'Отчеты о рассылках (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Update', 0, 'Редактирование рассылки (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_View', 0, 'Отчет об отправке (админка)', NULL, 'N;', 0),
('MailerRecipientAdmin_Manage', 0, 'Статистика получателей рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Create', 0, 'Добавление шаблона рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Delete', 0, 'Удаление шаблона рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Manage', 0, 'Управление шаблонами рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Update', 0, 'Редактирование шаблона рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_View', 0, 'Просмотр шаблона рассылки (админка)', NULL, 'N;', 0),
('Mailer_ConfirmReceipt', 0, 'Подтверждение получения письма', NULL, 'N;', 1),
('Mailer_SendMails', 0, 'Отправить письма', NULL, 'N;', 1),
('MainAdmin_AdminLinkProcess', 0, 'Переход по ссылке в админ панель (админка)', NULL, 'N;', 0),
('MainAdmin_ChangeOrder', 0, 'Сортировка (админка)', NULL, 'N;', 0),
('MainAdmin_Index', 0, 'Просмотр главной страницы (админка)', NULL, 'N;', 0),
('MainAdmin_Modules', 0, 'Просмотр списка модулей (админка)', NULL, 'N;', 0),
('MainAdmin_SessionLanguage', 0, 'Установка языка (админка)', NULL, 'N;', 0),
('MainAdmin_SessionPerPage', 0, 'Установки кол-ва элементов на странице (админка)', NULL, 'N;', 0),
('Main_Error', 0, 'Ошибка на странице', NULL, 'N;', 1),
('Main_Search', 0, 'Поиск по сайту', NULL, 'N;', 1),
('MenuAdmin_Create', 0, 'Добавление меню (админка)', NULL, 'N;', 0),
('MenuAdmin_Delete', 0, 'Удаление меню (админка)', NULL, 'N;', 0),
('MenuAdmin_Manage', 0, 'Управление меню (админка)', NULL, 'N;', 0),
('MenuAdmin_Update', 0, 'Редактирование меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_AjaxFillTree', 0, 'Загрузка дерева ссылок (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Create', 0, 'Добавление ссылки меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Delete', 0, 'Удаление ссылки меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Index', 0, 'Управление ссылками меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Update', 0, 'Редактирование ссылки меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_View', 0, 'Просмотр ссылки меню (админка)', NULL, 'N;', 0),
('moderator', 2, 'Модератор', '', 's:0:"";', 0),
('NewsAdmin_Create', 0, 'Добавление новости (админка)', NULL, 'N;', 0),
('NewsAdmin_Delete', 0, 'Удаление новости (админка)', NULL, 'N;', 0),
('NewsAdmin_Manage', 0, 'Управление новостями (админка)', NULL, 'N;', 0),
('NewsAdmin_Update', 0, 'Редактирование новости (админка)', NULL, 'N;', 0),
('NewsAdmin_View', 0, 'Просмотр новости (админка)', NULL, 'N;', 0),
('News_Index', 0, 'Список новостей', NULL, 'N;', 1),
('News_View', 0, 'Просмотр новости', NULL, 'N;', 1),
('OperationAdmin_AddAllOperations', 0, 'Добавление всех операций модулей (админка)', NULL, 'N;', 0),
('OperationAdmin_Create', 0, 'Добавление операции (админка)', NULL, 'N;', 0),
('OperationAdmin_Delete', 0, 'Удаление операции (админка)', NULL, 'N;', 0),
('OperationAdmin_GetModuleActions', 0, 'Получение операции модуля, JSON (админка)', NULL, 'N;', 0),
('OperationAdmin_GetModules', 0, 'Получение модулей, JSON (админка)', NULL, 'N;', 0),
('OperationAdmin_Manage', 0, 'Управление операциями (админка)', NULL, 'N;', 0),
('OperationAdmin_Update', 0, 'Редактирование операции (админка)', NULL, 'N;', 0),
('OperationAdmin_View', 0, 'Просмотр операции (админка)', NULL, 'N;', 0),
('PageAdmin_Create', 0, 'Добавление страницы (админка)', NULL, 'N;', 0),
('PageAdmin_Delete', 0, 'Удаление страницы (админка)', NULL, 'N;', 0),
('PageAdmin_GetJsonData', 0, 'Получение данных страницы (JSON) (админка)', NULL, 'N;', 0),
('PageAdmin_Manage', 0, 'Управление страницами (админка)', NULL, 'N;', 0),
('PageAdmin_Update', 0, 'Редактирование страницы (админка)', NULL, 'N;', 0),
('PageAdmin_View', 0, 'Просмотр страницы (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Create', 0, 'Добавление контентного блока (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Delete', 0, 'Удаление контентного блока (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Manage', 0, 'Управление контентными блоками (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Update', 0, 'Редактирование контентного блока (админка)', NULL, 'N;', 0),
('PageBlockAdmin_View', 0, 'Просмотр контентного блока (админка)', NULL, 'N;', 0),
('Page_Main', 0, 'Главная страница', NULL, 'N;', 1),
('Page_View', 0, 'Просмотр страницы', NULL, 'N;', 1),
('RoleAdmin_Assignment', 0, 'Назначение ролей (админка)', NULL, 'N;', 0),
('RoleAdmin_Create', 0, 'Добавление роли (админка)', NULL, 'N;', 0),
('RoleAdmin_Delete', 0, 'Удаление роли (админка)', NULL, 'N;', 0),
('RoleAdmin_Manage', 0, 'Управление ролями (админка)', NULL, 'N;', 0),
('RoleAdmin_Update', 0, 'Редактирование роли (админка)', NULL, 'N;', 0),
('RoleAdmin_View', 0, 'Просмотр роли (админка)', NULL, 'N;', 0),
('SettingAdmin_Manage', 0, 'Управление настройками (админка)', NULL, 'N;', 0),
('SettingAdmin_Update', 0, 'Редактирование настройки (админка)', NULL, 'N;', 0),
('SettingAdmin_View', 0, 'Просмотр настройки (админка)', NULL, 'N;', 0),
('SiteActionAdmin_Index', 0, 'Просмотр действий сайта (админка)', NULL, 'N;', 0),
('TaskAdmin_Allow', 0, 'Разрешение задачи для роли (админка)', NULL, 'N;', 0),
('TaskAdmin_Create', 0, 'Добавление задачи (админка)', NULL, 'N;', 0),
('TaskAdmin_Delete', 0, 'Удаление задачи (админка)', NULL, 'N;', 0),
('TaskAdmin_Deny', 0, 'Запрещение задачи для роли (админка)', NULL, 'N;', 0),
('TaskAdmin_Manage', 0, 'Управление задачами (админка)', NULL, 'N;', 0),
('TaskAdmin_RolesTasks', 0, 'Назначение задач для роли (админка)', NULL, 'N;', 0),
('TaskAdmin_Update', 0, 'Редактирование задачи (админка)', NULL, 'N;', 0),
('TaskAdmin_View', 0, 'Просмотр задачи (админка)', NULL, 'N;', 0),
('user', 2, 'Пользователь', '', 's:7:"s:0:"";";', 0),
('UserAdmin_Create', 0, 'Добавление пользователя (админка)', NULL, 'N;', 0),
('UserAdmin_Delete', 0, 'Удаление пользователя (админка)', NULL, 'N;', 0),
('UserAdmin_Login', 0, 'Авторизация (админка)', NULL, 's:9:"s:2:"N;";";', 1),
('UserAdmin_Manage', 0, 'Управление пользователями (админка)', NULL, 'N;', 0),
('UserAdmin_Update', 0, 'Редактирование пользователя (админка)', NULL, 'N;', 0),
('UserAdmin_View', 0, 'Просмотр пользователя (админка)', NULL, 'N;', 0),
('Users_Account', 1, 'Авторизация, регистрация, смена пароля', NULL, 's:0:"";', 1),
('User_ActivateAccount', 0, 'Активация аккаунта', NULL, 'N;', 0),
('User_ActivateAccountRequest', 0, 'Пользователи:Запрос на активацию аккаунта', NULL, 'N;', 0),
('User_ChangePassword', 0, 'Смена пароля', NULL, 'N;', 0),
('User_ChangePasswordRequest', 0, 'Запрос на смену пароля', NULL, 'N;', 0),
('User_Login', 0, 'Авторизация', NULL, 'N;', 1),
('User_Logout', 0, 'Выход', NULL, 'N;', 1),
('User_Registration', 0, 'Регистрация', NULL, 'N;', 1),
('View_Pages', 1, 'Просмотр страниц', NULL, 's:0:"";', 0),
('YmarketBrandAdmin_Manage', 0, 'Бренды (админка)', NULL, 'N;', 0),
('YmarketCronAdmin_Manage', 0, 'Фоновые задания (админка)', NULL, 'N;', 0),
('YmarketCronAdmin_Update', 0, 'Редактирование фонового задания (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Create', 0, 'Добавление IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Delete', 0, 'Удаление IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Manage', 0, 'IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Update', 0, 'Редактирование IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketProductAdmin_Delete', 0, 'Удаление продукта Яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketProductAdmin_Manage', 0, 'Продукты Яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketProductAdmin_View', 0, 'Просмотр продукта Яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Create', 0, 'Создание раздела яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Delete', 0, 'Удаление раздела яндекс маркета? (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Manage', 0, 'Разделы яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Update', 0, 'Редактирование раздела яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_View', 0, 'Просмотр раздела яндекс маркета (админка)', NULL, 'N;', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_items_childs`
--

DROP TABLE IF EXISTS `auth_items_childs`;
CREATE TABLE IF NOT EXISTS `auth_items_childs` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_items_childs`
--

INSERT INTO `auth_items_childs` (`parent`, `child`) VALUES
('Actions_Admin', 'ActionAdmin_Create'),
('Actions_Admin', 'ActionAdmin_Delete'),
('Actions_Admin', 'ActionAdmin_Manage'),
('Actions_Admin', 'ActionAdmin_Update'),
('Actions_Admin', 'ActionAdmin_View'),
('Actions_Admin', 'ActionFileAdmin_Create'),
('Actions_Admin', 'ActionFileAdmin_Delete'),
('Actions_Admin', 'ActionFileAdmin_Manage'),
('moderator', 'Actions_Admin'),
('moderator', 'Admin_Content'),
('moderator', 'Admin_Documents'),
('moderator', 'Admin_Faq'),
('moderator', 'Admin_Feedback'),
('moderator', 'Admin_Main'),
('moderator', 'Admin_News'),
('moderator', 'Admin_Pages'),
('Articles_Admin', 'ArticleAdmin_Create'),
('Articles_Admin', 'ArticleAdmin_Delete'),
('Articles_Admin', 'ArticleAdmin_Manage'),
('Articles_Admin', 'ArticleAdmin_Update'),
('Articles_Admin', 'ArticleAdmin_View'),
('Articles_Admin', 'ArticleSectionAdmin_Create'),
('Articles_Admin', 'ArticleSectionAdmin_Delete'),
('Articles_Admin', 'ArticleSectionAdmin_GetSectionInSidebar'),
('Articles_Admin', 'ArticleSectionAdmin_Manage'),
('Articles_Admin', 'ArticleSectionAdmin_Update'),
('Articles_Admin', 'ArticleSectionAdmin_View'),
('moderator', 'Articles_Admin'),
('Admin_Cities_Countries', 'CityAdmin_Create'),
('Admin_Cities_Countries', 'CityAdmin_Delete'),
('Admin_Cities_Countries', 'CityAdmin_Manage'),
('Admin_Cities_Countries', 'CityAdmin_Update'),
('Admin_Cities_Countries', 'CountryAdmin_Create'),
('Admin_Cities_Countries', 'CountryAdmin_Delete'),
('Admin_Cities_Countries', 'CountryAdmin_Manage'),
('Admin_Cities_Countries', 'CountryAdmin_Update'),
('Admin_Documents', 'DocumentAdmin_Create'),
('Admin_Documents', 'DocumentAdmin_Delete'),
('Admin_Documents', 'DocumentAdmin_Manage'),
('Admin_Documents', 'DocumentAdmin_Update'),
('Admin_Documents', 'DocumentAdmin_View'),
('Admin_Documents', 'DocumentFileAdmin_Create'),
('Admin_Documents', 'DocumentFileAdmin_Delete'),
('Admin_Documents', 'DocumentFileAdmin_Manage'),
('Admin_Documents', 'DocumentFileAdmin_Update'),
('Admin_Faq', 'FaqAdmin_Create'),
('Admin_Faq', 'FaqAdmin_Delete'),
('Admin_Faq', 'FaqAdmin_Manage'),
('Admin_Faq', 'FaqAdmin_Update'),
('Admin_Faq', 'FaqAdmin_View'),
('Admin_Faq', 'FaqSectionAdmin_Create'),
('Admin_Faq', 'FaqSectionAdmin_Delete'),
('Admin_Faq', 'FaqSectionAdmin_Manage'),
('Admin_Faq', 'FaqSectionAdmin_Update'),
('Admin_Faq', 'FaqSectionAdmin_View'),
('Admin_Feedback', 'FeedbackAdmin_Delete'),
('Admin_Feedback', 'FeedbackAdmin_Manage'),
('Admin_Feedback', 'FeedbackAdmin_View'),
('Admin_Languages', 'LanguageAdmin_Create'),
('Admin_Languages', 'LanguageAdmin_Delete'),
('Admin_Languages', 'LanguageAdmin_Manage'),
('Admin_Languages', 'LanguageAdmin_Update'),
('Admin_Main', 'LogAdmin_View'),
('Admin_Main', 'MainAdmin_ChangeOrder'),
('Admin_Main', 'MainAdmin_Index'),
('Admin_Main', 'MainAdmin_Modules'),
('Admin_Main', 'MainAdmin_SessionLanguage'),
('Admin_Main', 'MainAdmin_SessionPerPage'),
('Admin_Content', 'MenuAdmin_Create'),
('Admin_Content', 'MenuAdmin_Delete'),
('Admin_Content', 'MenuAdmin_Manage'),
('Admin_Content', 'MenuAdmin_Update'),
('Admin_Content', 'MenuLinkAdmin_AjaxFillTree'),
('Admin_Content', 'MenuLinkAdmin_Create'),
('Admin_Content', 'MenuLinkAdmin_Delete'),
('Admin_Content', 'MenuLinkAdmin_Index'),
('Admin_Content', 'MenuLinkAdmin_Update'),
('Admin_Content', 'MenuLinkAdmin_View'),
('Admin_News', 'NewsAdmin_Create'),
('Admin_News', 'NewsAdmin_Delete'),
('Admin_News', 'NewsAdmin_Manage'),
('Admin_News', 'NewsAdmin_Update'),
('Admin_News', 'NewsAdmin_View'),
('Admin_RBAC', 'OperationAdmin_AddAllOperations'),
('Admin_RBAC', 'OperationAdmin_Create'),
('Admin_RBAC', 'OperationAdmin_Delete'),
('Admin_RBAC', 'OperationAdmin_GetModuleActions'),
('Admin_Main', 'OperationAdmin_GetModules'),
('Admin_RBAC', 'OperationAdmin_Manage'),
('Admin_RBAC', 'OperationAdmin_Update'),
('Admin_RBAC', 'OperationAdmin_View'),
('Admin_Content', 'PageAdmin_Create'),
('Admin_Content', 'PageAdmin_Delete'),
('Admin_Content', 'PageAdmin_Manage'),
('Admin_Content', 'PageAdmin_Update'),
('Admin_Content', 'PageAdmin_View'),
('Admin_Content', 'PageBlockAdmin_Create'),
('Admin_Content', 'PageBlockAdmin_Delete'),
('Admin_Content', 'PageBlockAdmin_Manage'),
('Admin_Content', 'PageBlockAdmin_Update'),
('Admin_Content', 'PageBlockAdmin_View'),
('Admin_RBAC', 'RoleAdmin_Create'),
('Admin_RBAC', 'RoleAdmin_Delete'),
('Admin_RBAC', 'RoleAdmin_Manage'),
('Admin_RBAC', 'RoleAdmin_Update'),
('Admin_RBAC', 'RoleAdmin_View'),
('Admin_Settings', 'SettingAdmin_Manage'),
('Admin_Settings', 'SettingAdmin_Update'),
('Admin_Settings', 'SettingAdmin_View'),
('Admin_Main', 'SiteActionAdmin_Index'),
('Admin_RBAC', 'TaskAdmin_Create'),
('Admin_RBAC', 'TaskAdmin_Delete'),
('Admin_RBAC', 'TaskAdmin_Manage'),
('Admin_RBAC', 'TaskAdmin_Update'),
('Admin_RBAC', 'TaskAdmin_View'),
('Admin_Users', 'UserAdmin_Create'),
('Admin_Users', 'UserAdmin_Delete'),
('Users_Account', 'UserAdmin_Login'),
('Admin_Users', 'UserAdmin_Manage'),
('Admin_Users', 'UserAdmin_Update'),
('Admin_Users', 'UserAdmin_View'),
('guest', 'Users_Account'),
('moderator', 'Users_Account'),
('Users_Account', 'User_ActivateAccount'),
('Users_Account', 'User_ChangePassword'),
('Users_Account', 'User_ChangePasswordRequest'),
('Users_Account', 'User_Login'),
('Users_Account', 'User_Registration');

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(11) unsigned DEFAULT NULL,
  `metric_id` int(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Дамп данных таблицы `data`
--

INSERT INTO `data` (`id`, `sector_id`, `metric_id`, `value`) VALUES
(1, 1, 1, '10'),
(2, 2, 1, '20'),
(3, 3, 1, '30'),
(4, 4, 1, '40'),
(5, 5, 1, '30'),
(7, 1, 6, '9900'),
(8, 2, 6, '9900'),
(9, 3, 6, '12000'),
(10, 4, 6, '7200'),
(11, 5, 6, '10200'),
(12, 1, 3, '1'),
(13, 2, 3, '1'),
(14, 3, 3, '1'),
(15, 4, 3, '1'),
(16, 5, 3, '1'),
(22, 1, 5, '58'),
(23, 2, 5, '71'),
(24, 3, 5, '82'),
(25, 4, 5, '54'),
(26, 5, 5, '76'),
(27, 1, 4, '4'),
(28, 2, 4, '4'),
(29, 3, 4, '3'),
(30, 4, 4, '1'),
(31, 5, 4, '7'),
(32, 1, 7, NULL),
(33, 2, 7, NULL),
(34, 3, 7, NULL),
(35, 4, 7, NULL),
(36, 5, 7, NULL),
(37, 1, 2, '0'),
(38, 2, 2, '0'),
(39, 3, 2, '1'),
(40, 4, 2, '0'),
(41, 5, 2, '0'),
(42, 6, 1, '1'),
(43, 6, 2, '0'),
(44, 6, 3, '0'),
(45, 6, 4, '3'),
(46, 6, 5, '67\r\n'),
(47, 6, 6, '5700'),
(48, 6, 7, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `metrics`
--

DROP TABLE IF EXISTS `metrics`;
CREATE TABLE IF NOT EXISTS `metrics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'Название',
  `name` varchar(255) DEFAULT NULL COMMENT 'Переменная(латинские буквы, без пробелов)',
  `formula` text,
  `min` varchar(255) DEFAULT NULL,
  `norma` varchar(255) DEFAULT NULL,
  `max` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'На каком уровне рассматривать',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `metrics`
--

INSERT INTO `metrics` (`id`, `title`, `name`, `formula`, `min`, `norma`, `max`, `type`, `lft`, `rgt`, `depth`) VALUES
(1, 'Детские сады', 'detsad', 'peoples * 0.06 * (3 / 5) / metric', '1', '300', '450', '2', 5, 6, 5),
(2, 'Поликлиники', 'policlinic', NULL, NULL, NULL, NULL, '2', 4, 7, 4),
(3, 'Школы', 'school', 'metric', 'peoples *  0.2/ 2200', 'peoples *  0.2/ 1200', 'peoples *  0.2/ 400', '2', 3, 8, 3),
(4, 'Спорт площадки', 'sportplace', NULL, NULL, NULL, NULL, '2', 9, 10, 3),
(5, 'Мусорные контейнеры', 'garbagecontainer', 'metric * 1.1 * 365', 'peoples * 1.4 / 2', 'peoples * 1.4', 'peoples * 1.4 * 2', '1', 2, 11, 2),
(6, 'Население', 'peoples', NULL, NULL, NULL, NULL, NULL, 12, 13, 2),
(7, 'Количество участковых', 'policemans', 'peoples / metric', '2000', '3000', '4000', '1', 14, 15, 2),
(8, 'root', 'root', NULL, NULL, NULL, NULL, NULL, 1, 16, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `polygons`
--

DROP TABLE IF EXISTS `polygons`;
CREATE TABLE IF NOT EXISTS `polygons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(11) DEFAULT NULL,
  `lat` decimal(16,10) DEFAULT NULL,
  `lng` decimal(16,10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `LatLng` (`lat`,`lng`,`sector_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=634 ;

--
-- Дамп данных таблицы `polygons`
--

INSERT INTO `polygons` (`id`, `sector_id`, `lat`, `lng`) VALUES
(120, 1, 51.1512212709, 71.4561081639),
(119, 1, 51.1524864645, 71.4607859365),
(118, 1, 51.1490407494, 71.4635754338),
(117, 1, 51.1489330667, 71.4656353704),
(116, 1, 51.1461130353, 71.4655495397),
(115, 1, 51.1461063048, 71.4598847142),
(177, 2, 51.1490542097, 71.4636183492),
(176, 2, 51.1489061459, 71.4657212010),
(175, 2, 51.1461063048, 71.4656353703),
(174, 2, 51.1457832353, 71.4697123281),
(173, 2, 51.1463755277, 71.4721585027),
(172, 2, 51.1540746372, 71.4666653386),
(171, 2, 51.1525133832, 71.4608717672),
(623, 3, 51.1460793825, 71.4599920026),
(622, 3, 51.1461197659, 71.4655709974),
(621, 3, 51.1457428514, 71.4696264974),
(620, 3, 51.1463889888, 71.4722014180),
(619, 3, 51.1445313195, 71.4734030477),
(618, 3, 51.1416504382, 71.4629317037),
(401, 5, 51.1445851661, 71.4734245053),
(400, 5, 51.1475735504, 71.4837885610),
(399, 5, 51.1518538720, 71.4806986562),
(398, 5, 51.1498820121, 71.4740575067),
(485, 4, 51.1529575386, 71.4739502184),
(484, 4, 51.1499022026, 71.4741326086),
(483, 4, 51.1517865749, 71.4808274022),
(482, 4, 51.1563625865, 71.4774370900),
(481, 4, 51.1567124982, 71.4761496297),
(397, 5, 51.1489869080, 71.4702916852),
(396, 5, 51.1469947344, 71.4718044511),
(581, 6, 51.1542899785, 71.4676416627),
(580, 6, 51.1540477195, 71.4667189828),
(579, 6, 51.1490643049, 71.4703399649),
(578, 6, 51.1492897647, 71.4712036363),
(480, 4, 51.1559251932, 71.4732206575),
(479, 4, 51.1552051677, 71.4736712686),
(478, 4, 51.1544312958, 71.4740306846),
(577, 6, 51.1495286836, 71.4722389690),
(576, 6, 51.1499560425, 71.4740896932),
(575, 6, 51.1523451414, 71.4741218797),
(574, 6, 51.1544111074, 71.4739824048),
(573, 6, 51.1558915474, 71.4732099286),
(572, 6, 51.1550571234, 71.4701414814),
(571, 6, 51.1546937406, 71.4689076654),
(570, 6, 51.1544784012, 71.4682639352);

-- --------------------------------------------------------

--
--  `preview`
--
DROP VIEW IF EXISTS `preview`;
CREATE TABLE IF NOT EXISTS `preview` (
`id` int(11) unsigned
,`title` varchar(100)
,`edges_count` int(5)
,`e_count` bigint(21)
);
-- --------------------------------------------------------

--
-- Структура таблицы `sectors`
--

DROP TABLE IF EXISTS `sectors`;
CREATE TABLE IF NOT EXISTS `sectors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `square_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `sectors`
--

INSERT INTO `sectors` (`id`, `title`, `square_id`) VALUES
(1, '1-й', 1),
(2, '2-й', 1),
(3, '3-й', 1),
(4, '4-й', 1),
(5, '5-й', 1),
(6, 'ТЦ "Евразия"', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `squares`
--

DROP TABLE IF EXISTS `squares`;
CREATE TABLE IF NOT EXISTS `squares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `squares`
--

INSERT INTO `squares` (`id`, `title`) VALUES
(1, 'Алматинский');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL COMMENT 'Имя',
  `last_name` varchar(40) DEFAULT NULL COMMENT 'Фамилия',
  `patronymic` varchar(40) DEFAULT NULL COMMENT 'Отчество',
  `email` varchar(200) NOT NULL COMMENT 'Email',
  `phone` varchar(50) DEFAULT NULL COMMENT 'Мобильный телефон',
  `password` varchar(32) NOT NULL COMMENT 'Пароль',
  `birthdate` date DEFAULT NULL COMMENT 'Дата рождения',
  `gender` enum('man','woman') DEFAULT NULL COMMENT 'Пол',
  `status` enum('active','new','blocked') DEFAULT 'new' COMMENT 'Статус',
  `activate_code` varchar(32) DEFAULT NULL COMMENT 'Код активации',
  `activate_date` datetime DEFAULT NULL COMMENT 'Дата активации',
  `password_recover_code` varchar(32) DEFAULT NULL,
  `password_recover_date` datetime DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Зарегистрирован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `patronymic`, `email`, `phone`, `password`, `birthdate`, `gender`, `status`, `activate_code`, `activate_date`, `password_recover_code`, `password_recover_date`, `date_create`) VALUES
(1, '', NULL, NULL, 'www.pismeco@gmail.com', NULL, '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, 'active', NULL, NULL, NULL, NULL, '2012-08-02 14:48:46'),
(2, '', NULL, NULL, 'admin@admin.ru', NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, 'active', NULL, NULL, NULL, NULL, '2012-08-02 15:28:06');

-- --------------------------------------------------------

--
--  `preview`
--
DROP TABLE IF EXISTS `preview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `preview` AS select `node`.`id` AS `id`,`node`.`title` AS `title`,`node`.`edges_count` AS `edges_count`,(select count(0) AS `count(*)` from `edge_copy` `b` where ((`b`.`source` = `node`.`id`) or (`b`.`target` = `node`.`id`))) AS `e_count` from `node`;
