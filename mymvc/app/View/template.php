<?php
$pageData = new \App\Helper\PageData($data);
$template = new \App\Helper\Template();

/*
 * Main content
 */
$dynamicPageContent = '';
if ($pageData->mainPage !== '') {
    if (file_exists(__DIR__ . "/page/" . $pageData->mainPage . '.php')) {
        ob_start();
        include_once(__DIR__ . "/page/" . $pageData->mainPage . '.php');
        $dynamicPageContent = ob_get_contents();
        ob_clean();
        ob_end_flush();
    }
}

echo $template->getFromTemplateFile('common.html', [
    '__title__' => $pageData->title,
    '__baseurl__' => $pageData->baseurl,
    '__dynamic_content__' => $dynamicPageContent
]);