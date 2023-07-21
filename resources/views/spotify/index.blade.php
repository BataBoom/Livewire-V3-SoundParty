@extends('layouts.v3')
@section('title', 'Home')
@section('content')

 <!-- Content Wrapper -->
        <div id="app-onboarding" class="view-wrapper is-webapp" data-page-title="Sound Party" data-naver-offset="214" data-menu-item="#layouts-navbar-menu" data-mobile-item="#home-sidebar-menu-mobile">

            <div class="page-content-wrapper">
                <div class="page-content is-relative">

                    <div class="page-title has-text-centered is-webapp">

                        <div class="title-wrap">
                            <h1 class="title is-4">Sound Party</h1>
                        </div>

                        <div class="toolbar ml-auto">

                            <div class="toolbar-link">
                                <label class="dark-mode ml-auto">
                                    <input type="checkbox" checked>
                                    <span></span>
                                </label>
                            </div>

                            
                            @auth
                            <div class="toolbar-notifications is-hidden-mobile">
                                <div class="dropdown is-spaced is-dots is-right dropdown-trigger">
                                    <div class="is-trigger" aria-haspopup="true">
                                        <i data-feather="bell"></i>
                                        <span class="new-indicator pulsate"></span>
                                    </div>
                                    <div class="dropdown-menu" role="menu">
                                        <div class="dropdown-content">
                                            <div class="heading">
                                                <div class="heading-left">
                                                    <h6 class="heading-title">Notifications</h6>
                                                </div>
                                                <div class="heading-right">
                                                    <a class="notification-link" href="/admin-profile-notifications.html">See all</a>
                                                </div>
                                            </div>
                                            <ul class="notification-list">
                                                <li>
                                                    <a class="notification-item">
                                                        <div class="img-left">
                                                            <img class="user-photo" alt="" src="https://via.placeholder.com/150x150" data-demo-src="assets/img/avatars/photos/7.jpg" />
                                                        </div>
                                                        <div class="user-content">
                                                            <p class="user-info"><span class="name">Alice C.</span> left a comment.</p>
                                                            <p class="time">1 hour ago</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="notification-item">
                                                        <div class="img-left">
                                                            <img class="user-photo" alt="" src="https://via.placeholder.com/150x150" data-demo-src="assets/img/avatars/photos/12.jpg" />
                                                        </div>
                                                        <div class="user-content">
                                                            <p class="user-info"><span class="name">Joshua S.</span> uploaded a file.</p>
                                                            <p class="time">2 hours ago</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="notification-item">
                                                        <div class="img-left">
                                                            <img class="user-photo" alt="" src="https://via.placeholder.com/150x150" data-demo-src="assets/img/avatars/photos/13.jpg" />
                                                        </div>
                                                        <div class="user-content">
                                                            <p class="user-info"><span class="name">Tara S.</span> sent you a message.</p>
                                                            <p class="time">2 hours ago</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="notification-item">
                                                        <div class="img-left">
                                                            <img class="user-photo" alt="" src="https://via.placeholder.com/150x150" data-demo-src="assets/img/avatars/photos/25.jpg" />
                                                        </div>
                                                        <div class="user-content">
                                                            <p class="user-info"><span class="name">Melany W.</span> left a comment.</p>
                                                            <p class="time">3 hours ago</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endauth

                           
                        </div>
                    </div>

                    <div class="page-content-inner">
                    	 <!--Personal Dashboard V2-->
                        <div class="personal-dashboard personal-dashboard-v2">

                            <div class="columns is-multiline">
                                @auth
                                <div class="column is-12">
                                    <div class="dashboard-header">
                                        <div class="h-avatar is-xl">
                                            <img class="avatar" src="{{ Auth::user()->profile_photo_url }}" alt="">
                                            <img class="badge" src="https://hui.tengiginnanet.link/assets/img/icons/flags/united-states-of-america.svg" alt="">
                                        </div>
                                        <div class="user-meta is-dark-bordered-12">
                                            <h3 class="title is-4 is-narrow is-bold">Welcome back, {{ Auth::user()->name }}</h3>
                                            <p class="light-text">It's really nice to see you again</p>
                                        </div>
                                        <div class="user-action">
                                            <h3 class="title is-2 is-narrow">{{ $partyCount ?? 1 }}</h3>
                                            <p class="light-text">Party Members</p>
                                            <a class="action-link h-modal-trigger"  data-modal="demo-large-form-modal">Edit party?</a>
                                        </div>
                                        <div class="cta h-hidden-tablet-p">
                                            <div class="media-flex inverted-text">
                                            
                                                <p class="white-text">Spotify Premium Account Required?!</p>
                                            </div>
                                            <a class="link inverted-text h-modal-trigger" data-modal="demo-standard-modal">Learn More (Premium Code Giveaway)</a>
                                        </div>
                                    </div>
                                </div>
                                @endauth

                                <div class="column is-fullwidth">
                                   
                                       
                                         

<livewire:skippy :partykey="$partykey" lazy/>
                                      
                                </div>

                                </div>

                               

                                    
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            <div id="demo-large-form-modal" class="modal h-modal is-large">
            <div class="modal-background h-modal-close"></div>
            <div class="modal-content">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <h3>Manage Party - Coming Soon</h3>
                        <button class="h-modal-close ml-auto" aria-label="close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </header>
                    <div class="modal-card-body">
                        <div class="inner-content">
                            <div class="modal-form">
                                <div class="columns is-multiline">
                                    <div class="column is-12">
                                        <div class="field">
                                            <label>Project Name *</label>
                                            <div class="control">
                                                <input type="text" class="input" placeholder="Ex: A cool project">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <div class="field">
                                            <label>Project Members</label>
                                            <div class="control is-combo">
                                                <div class="stacked-combo-box has-rounded-images">
                                                    <div class="box-inner">
                                                        <div class="combo-item">
                                                            <img src="assets/img/avatars/placeholder.jpg" data-demo-src="assets/img/avatars/placeholder.jpg" alt="">
                                                            <span class="selected-item">Add people</span>
                                                        </div>
                                                    </div>
                                                    <div class="box-chevron">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                                    </div>
                                                    <div class="box-dropdown">
                                                        <div class="dropdown-inner has-slimscroll">
                                                            <ul>
                                                                <li>
                                                                    <span class="item-icon">
                                                                      <img src="assets/img/avatars/photos/22.jpg" data-demo-src="assets/img/avatars/photos/22.jpg" alt="">
                                                                  </span>
                                                                    <span class="item-name">Jimmy H.</span>
                                                                    <span class="checkmark">
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                                  </span>
                                                                </li>
                                                                <li>
                                                                    <span class="item-icon">
                                                                      <img src="assets/img/avatars/photos/8.jpg" data-demo-src="assets/img/avatars/photos/8.jpg" alt="">
                                                                  </span>
                                                                    <span class="item-name">Erik K.</span>
                                                                    <span class="checkmark">
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                                  </span>
                                                                </li>
                                                                <li>
                                                                    <span class="item-icon">
                                                                      <img src="assets/img/avatars/photos/7.jpg" data-demo-src="assets/img/avatars/photos/7.jpg" alt="">
                                                                  </span>
                                                                    <span class="item-name">Alice C.</span>
                                                                    <span class="checkmark">
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                                  </span>
                                                                </li>
                                                                <li>
                                                                    <span class="item-icon">
                                                                      <img src="assets/img/avatars/photos/25.jpg" data-demo-src="assets/img/avatars/photos/25.jpg" alt="">
                                                                  </span>
                                                                    <span class="item-name">Melany W.</span>
                                                                    <span class="checkmark">
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                                  </span>
                                                                </li>
                                                                <li>
                                                                    <span class="item-icon">
                                                                      <img src="assets/img/avatars/photos/12.jpg" data-demo-src="assets/img/avatars/photos/12.jpg" alt="">
                                                                  </span>
                                                                    <span class="item-name">Joshua S.</span>
                                                                    <span class="checkmark">
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                                  </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <div class="field">
                                            <label>Project Type *</label>
                                            <div class="control">
                                                <div class="h-select">
                                                    <div class="select-box">
                                                        <span>Select a type</span>
                                                    </div>
                                                    <div class="select-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                                    </div>
                                                    <div class="select-drop has-slimscroll-sm">
                                                        <div class="drop-inner">
                                                            <div class="option-row">
                                                                <input type="radio" name="project_type">
                                                                <div class="option-meta">
                                                                    <span>Web development</span>
                                                                </div>
                                                            </div>
                                                            <div class="option-row">
                                                                <input type="radio" name="project_type">
                                                                <div class="option-meta">
                                                                    <span>Design</span>
                                                                </div>
                                                            </div>
                                                            <div class="option-row">
                                                                <input type="radio" name="project_type">
                                                                <div class="option-meta">
                                                                    <span>Marketing</span>
                                                                </div>
                                                            </div>
                                                            <div class="option-row">
                                                                <input type="radio" name="project_type">
                                                                <div class="option-meta">
                                                                    <span>Software</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <div class="field">
                                            <label>Project Budget *</label>
                                            <div class="control">
                                                <input type="text" class="input" placeholder="Ex: $3,500">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <div class="field">
                                            <label>Project URL *</label>
                                            <div class="control">
                                                <input type="text" class="input" placeholder="Ex: https://project.com">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-12">
                                        <div class="field">
                                            <label>Description *</label>
                                            <div class="control">
                                                <textarea class="textarea" rows="3" placeholder="Details about the project..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-card-foot is-end">
                        <a class="button h-button is-rounded is-danger">Delete Party</a>
                        <a class="button h-button is-rounded h-modal-close">Cancel</a>
                        <a class="button h-button is-primary is-raised is-rounded">Save</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="demo-standard-modal" class="modal h-modal">
            <div class="modal-background h-modal-close"></div>
            <div class="modal-content">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <h3>Spotify Message</h3>
                        <button class="h-modal-close ml-auto" aria-label="close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </header>
                    <div class="modal-card-body">
                        <div class="inner-content">
                            <div class="section-placeholder">
                                <div class="placeholder-content">
                                    <div class="h-avatar is-xl">
                                        <img class="avatar" src="assets/img/avatars/photos/22.jpg" data-demo-src="assets/img/avatars/photos/22.jpg" alt="">
                                        <img class="badge" src="assets/img/icons/flags/united-states-of-america.svg" data-demo-src="assets/img/icons/flags/united-states-of-america.svg" alt="">
                                    </div>
                                    <h3 class="dark-inverted">Hang tight</h3>
                                    <p>Spotify Giveaway coming soon</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-card-foot is-centered">
                        <a class="button h-button is-rounded h-modal-close">Close</a>
                        <a class="button h-button is-primary is-raised is-rounded">Save</a>
                    </div>
                </div>
            </div>
        </div>

