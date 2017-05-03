<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cityware\View;

use Zend\View\View as ZendView;

/**
 * Description of View
 *
 * @author fabricio.xavier
 */
class View extends ZendView {

    /**
     * Função de processamento dos Helpers setados no controller
     * @param \Zend\Mvc\MvcEvent $e
     */
    public static function processViewHelpersInControllers($e) {
        $viewHelperManager = $e->getApplication()->getServiceManager()->get('ViewHelperManager');

        if (isset($_SESSION['processHead'])) {
            $process = $_SESSION['processHead'];
            unset($_SESSION['processHead']);
        } else {
            $process = null;
        }
        /**
         * Definbe um novo ou adiciona outro Titulo da página
         */
        if (isset($process['headTitle']) and ! empty($process['headTitle'])) {
            $headTitle = $viewHelperManager->get('headTitle');
            $headTitle($process['headTitle']['title'], $process['headTitle']['type'])->setSeparator($process['headTitle']['separator'])->setAutoEscape(false);
        }

        /**
         * Define o Doctype da página
         */
        if (isset($process['doctype']) and ! empty($process['doctype'])) {
            $doctype = $viewHelperManager->get('doctype');
            $doctype($process['doctype']);
        }

        /**
         * Define o Content Type da página
         */
        if (isset($process['contentType']) and ! empty($process['contentType'])) {
            $contentType = $viewHelperManager->get('headMeta');
            if (($process['doctype'] == \Zend\View\Helper\Doctype::XHTML5) or ( $process['doctype'] == \Zend\View\Helper\Doctype::HTML5)) {
                $contentType()->setCharset($process['contentType'])->setSeparator(PHP_EOL);
            } else {
                $contentType()->appendHttpEquiv('Content-Type', 'text/html; charset=' . $process['contentType'])->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define o Content Lang da página
         */
        if (isset($process['contentLang']) and ! empty($process['contentLang'])) {
            $contentLang = $viewHelperManager->get('headMeta');
            $contentLang()->appendHttpEquiv('Content-Language', $process['contentLang'])->setSeparator(PHP_EOL);
        }

        /**
         * Define Link de Estilo CSS ou Less da página
         */
        if (isset($process['headCssLink']) and ! empty($process['headCssLink'])) {
            $headCssLink = $viewHelperManager->get('headLink');
            foreach ($process['headCssLink'] as $key => $value) {
                if ($value['typeFile'] == 'css') {
                    $headCssLink()->appendStylesheet($value['url'], $value['media'], $value['conditional'])->setSeparator(PHP_EOL);
                } else if ($value['typeFile'] == 'less') {
                    $headCssLink()->appendStylesheet(URL_DEFAULT . 'less.php?' . $value['url'], $value['media'], $value['conditional'])->setSeparator(PHP_EOL);
                }
            }
        }

        /**
         * Define Link de Scripts JS na página
         */
        if (isset($process['headJsLink']) and ! empty($process['headJsLink'])) {
            $headJsLink = $viewHelperManager->get('headScript');
            foreach ($process['headJsLink'] as $key => $value) {
                $headJsLink()->appendFile($value['url'], $value['type'], $value['attrs'])->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define Link de cabeçalho da página
         */
        if (isset($process['headLink']) and ! empty($process['headLink'])) {
            $headLink = $viewHelperManager->get('headLink');
            foreach ($process['headLink'] as $valueHeadLink) {
                $headLink($valueHeadLink, 'PREPEND')->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define Estilo CSS na página
         */
        if (isset($process['headCssStyle']) and ! empty($process['headCssStyle'])) {
            $headCssLink = $viewHelperManager->get('headStyle');
            foreach ($process['headCssStyle'] as $key => $value) {
                $headCssLink()->appendStyle($value['css'], $value['conditional'])->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define Scripts JS na página
         */
        if (isset($process['headJsScript']) and ! empty($process['headJsScript'])) {
            $headJsScript = $viewHelperManager->get('headScript');
            foreach ($process['headJsScript'] as $key => $value) {
                $headJsScript()->appendScript($value['script'], $value['type'], $value['conditional'])->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define o Favicon da página
         */
        if (isset($process['favicon']) and ! empty($process['favicon'])) {
            $favicon = $viewHelperManager->get('headLink');
            if (($this->getDoctype() == \Zend\View\Helper\Doctype::XHTML5) or ( $this->getDoctype() == \Zend\View\Helper\Doctype::HTML5)) {
                $favicon(array('rel' => 'shortcut icon', 'href' => $process['favicon']), 'PREPEND')->setSeparator(PHP_EOL);
            } else {
                $favicon(array('rel' => 'favicon', 'href' => $process['favicon']), 'PREPEND')->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define Meta Tags do tipo Name
         */
        if (isset($process['metaName']) and ! empty($process['metaName'])) {
            $metaName = $viewHelperManager->get('headMeta');
            foreach ($process['metaName'] as $key => $value) {
                $metaName()->appendName($value['key'], $value['content'])->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define Meta Tags do tipo Property
         */
        if (isset($process['metaProperty']) and ! empty($process['metaProperty'])) {
            /**
             *
              $isFacebook = new \Cityware\View\Helper\IsFacebook();
              if ($isFacebook) {
              $this->getRenderer()->setDoctype(\Zend\View\Helper\Doctype::XHTML1_RDFA11);
              $this->getRenderer()->appendProperty($keyValue, $content)->setSeparator(PHP_EOL);
              }
             */
            $metaProperty = $viewHelperManager->get('headMeta');
            $doctype = $viewHelperManager->get('doctype');
            $doctype(\Zend\View\Helper\Doctype::XHTML1_RDFA11);

            foreach ($process['metaProperty'] as $key => $value) {
                $metaProperty()->appendProperty($value['key'], $value['content'])->setSeparator(PHP_EOL);
            }
        }

        /**
         * Define Meta Tags do tipo HttpEquiv
         */
        if (isset($process['metaHttpEquiv']) and ! empty($process['metaHttpEquiv'])) {
            $metaName = $viewHelperManager->get('headMeta');
            foreach ($process['metaHttpEquiv'] as $key => $value) {
                $metaName()->appendHttpEquiv($value['key'], $value['content'])->setSeparator(PHP_EOL);
            }
        }
    }

}
