<?php

declare(strict_types=1);

namespace Waglpz\Webapp\View\Helpers;

abstract class Navigation
{
    private string $menu;

    public function __construct()
    {
        $myNavUrl  = 'fake-navi-link';
        $myNavUrl2 = 'fake-navi-link-2';

        $this->menu  = <<<HTML
<li class="nav-item">
    <a class="nav-link my-2" href="$myNavUrl"> <i
    class="fas fa-inbox"
    style="
    text-shadow: 1px 1px 1px #fff; 
    font-size: 1.75em; 
    width: 1.75rem;
    color: #0056b3;"></i> <span>Link One</span></a>
</li>
HTML;
        $this->menu .= <<<HTML
<li class="nav-item">
    <a class="nav-link my-2" href="$myNavUrl2"> <i
    class="fas fa-tasks"
    style="
    text-shadow: 1px 1px 1px #fff; font-size: 1.75em; width: 1.75rem;"></i> <span>Link Two</span></a>
</li>

HTML;
    }

    public function topNavigation(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        $imgHtml = '<img
width="42"
style="float:right; margin-top: -4px; margin-left: 6px; margin-right: .7rem"
class="img-responsive rounded-circle"
src="%s"
alt=""/>';

        $picture     = $this->getPicture();
        $version     = $this->getVersion();
        $currentUser = $this->getCurrentUserName();

        return <<<HTML
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" style="border-top: 4px solid #007bff">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/">
        <img src="/images/logo.png" alt="Veolia LOGO" class="img-responsive"/>
    </a>
    
    <button class="navbar-toggler position-absolute d-md-none collapsed" 
            type="button" data-toggle="collapse" data-target="#sidebarMenu" 
            aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
   
<div class="col dropdown font-weight-bold float-left ml-3">    
    <span class="text-white text-decoration-none" title="Version: $version}">
       Welcome to Umbrella&trade Corp.
    </span> <span class="rounded font-italic bg-light p-1">$currentUser</span>
</div>
<div class="mr-1 pt-1" id="contextDropdownMenu">
<button class="btn btn-primary mt-n3 border-top-0" 
onclick="alert('Test')"><i
class="fas fa-upload mr-1"></i>Zunge Button</button>

  <a href="#" 
      class="dropdown  mb-n3" 
      data-toggle="dropdown" 
      data-display="static"
      aria-haspopup="true" 
      aria-expanded="false"
      style="text-decoration: none; color: rgba(255,255,255,.5)">
          $picture
<ul class="dropdown-menu text-center min-vh-100" style="right: 0">
    <li class="dropdown-item mb-2 bg-transparent"><a
                class="btn btn-primary" 
                href="/logout"><i class="fas fa-sign-out-alt mr-1"></i>loout</a></li>
    <li class="dropdown-item mb-2 ml-1 bg-transparent"><a
                class="d-block" 
                href="#" 
                ><i class="far fa-stop-circle mr-1"></i>logout</a></li>
</ul>  
 </a>


</di>
</nav>
HTML;
    }

    public function sideNavigation(): string
    {
        $releaseInfo = $this->getReleaseInfo();

        return <<<HTML
 <nav id="sidebarMenu" class="mt-3 col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">$this->menu</ul>
        <footer class="pt-3 footer fixed-bottom content container-fluid">
            <h6>
                <small class="font-italic text-muted">
                    Release: $releaseInfo 
                </small></h6>
        <footer>  
    </div>
</nav>
HTML;
    }

    public function __invoke(): self
    {
        // todo: remove work around, view helpers wo __invoke w'l not created via DI container
        return $this;
    }

    abstract protected function getReleaseInfo(): string;

    abstract protected function getPicture(): string;

    abstract protected function getVersion(): string;

    abstract protected function getCurrentUserName(): string;
}
