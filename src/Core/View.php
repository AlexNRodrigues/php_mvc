<?php

namespace Core;

class View
{
    protected $basePath;
    protected $layout = null;
    protected $data = [];

    public function __construct()
    {
        // Definir o caminho base para as views (pasta /src/Views)
        $this->basePath = __DIR__ . '/../Views';
    }

    /**
     * Define o layout a ser usado (opcional)
     * @param string $layout Nome do arquivo de layout (sem extensão)
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Passa dados para a view
     * @param array $data Dados a serem passados para a view
     * @return $this
     */
    public function with(array $data)
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Renderiza a view
     * @param string $view Nome do arquivo de view (sem extensão, relativo à pasta Views)
     * @return void
     * @throws \Exception
     */
    public function render($view)
    {
        $viewFile = $this->resolveViewPath($view);

        // Verificar se o arquivo de view existe
        if (!file_exists($viewFile)) {
            throw new \Exception("View file '$view' not found in path: $viewFile");
        }

        // Extrair os dados para o escopo da view
        extract($this->data);

        // Se não houver layout, apenas carregar a view diretamente
        if (!$this->layout) {
            ob_start();
            include $viewFile;
            echo ob_get_clean();
            return;
        }

        // Se houver layout, carregar a view dentro do layout
        $content = $this->getViewContent($viewFile);
        $layoutFile = $this->resolveViewPath($this->layout);

        if (!file_exists($layoutFile)) {
            throw new \Exception("Layout file '$this->layout' not found in path: $layoutFile");
        }

        ob_start();
        include $layoutFile;
        echo ob_get_clean();
    }

    /**
     * Resolve o caminho completo do arquivo de view
     * @param string $view Nome do arquivo de view
     * @return string Caminho completo do arquivo
     */
    private function resolveViewPath($view)
    {
        // Substituir pontos por barras e adicionar extensão .php
        $view = str_replace('.', '/', $view);
        return $this->basePath . '/' . $view . '.php';
    }

    /**
     * Obtém o conteúdo da view sem exibi-lo diretamente
     * @param string $viewFile Caminho do arquivo de view
     * @return string Conteúdo da view
     */
    private function getViewContent($viewFile)
    {
        extract($this->data);
        ob_start();
        include $viewFile;
        return ob_get_clean();
    }
}
