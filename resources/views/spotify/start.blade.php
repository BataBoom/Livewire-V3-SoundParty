@extends('layouts.v3')
@section('title', 'Host A Party')
@section('content')

 <!-- Content Wrapper -->
        <div id="app-onboarding" class="view-wrapper is-webapp" data-page-title="Sound Party" data-naver-offset="214" data-menu-item="#layouts-navbar-menu" data-mobile-item="#home-sidebar-menu-mobile">

            <div class="page-content-wrapper">
                <div class="page-content is-relative">

                    <div class="page-title has-text-centered is-webapp">

                        <div class="title-wrap">
                            <h1 class="title is-4">SoundParty</h1>
                        </div>
                        <div class="toolbar ml-auto">

                            <div class="toolbar-link">
                                <label class="dark-mode ml-auto">
                                    <input type="checkbox" checked="">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="page-content-inner">
                    	  <!--Pronotion Page-->
                        <div class="promotion-page-wrapper">
                            <div class="wrapper-outer">
                                <div class="wrapper-inner">
                                    <div class="action-box">
                                        <div class="box-content">
                                            <img class="light-image is-larger" src="{{ asset('images/mello.svg') }}" alt="" />
                                            <img class="dark-image is-larger" src="{{ asset('images/mello.svg') }}" alt="" />
                                            <h3 class="dark-inverted">Host A Party, a Sound Party</h3>
                                            <div class="price">
                                                <span class="dark-inverted">FREE</span>
                                                <span>Forever</span>
                                            </div>
                                            <div class="buttons">
                                                <a class="button is-fullwidth is-primary is-raised" href="{{ route('provider-auth', [
                                                'provider' => 'spotify']) }}"
                                                >Try it!</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="side-wrapper">
                                    <div class="side-inner">
                                        <div class="side-title">
                                            <h3 class="dark-inverted">SoundParty Features</h3>
                                            <p>Take a look at some incredible features</p>
                                        </div>

                                        <div class="action-list">
                                            <div class="media-flex">
                                                <div class="icon-wrap is-dark-primary is-dark-bg-3 is-dark-card-bordered">
                                                    <i data-feather="check"></i>
                                                </div>
                                                <div class="flex-meta">
                                                    <span>Unlimited Capacity</span>
                                                    <p>Invite to your parties content</p>
                                                </div>
                                            </div>
                                            <div class="media-flex">
                                                <div class="icon-wrap is-dark-primary is-dark-bg-3 is-dark-card-bordered">
                                                    <i data-feather="check"></i>
                                                </div>
                                                <div class="flex-meta">
                                                    <span>Unlimited Queue</span>
                                                    <p>Add songs to your queue directly in the webapp. Party members can add songs to queue.</p>
                                                </div>
                                            </div>
                                            <div class="media-flex">
                                                <div class="icon-wrap is-dark-primary is-dark-bg-3 is-dark-card-bordered">
                                                    <i data-feather="check"></i>
                                                </div>
                                                <div class="flex-meta">
                                                    <span>Search</span>
                                                    <p>Seamlessly search by artist or track</p>
                                                </div>
                                            </div>
                                            <div class="media-flex">
                                                <div class="icon-wrap is-dark-primary is-dark-bg-3 is-dark-card-bordered">
                                                    <i data-feather="check"></i>
                                                </div>
                                                <div class="flex-meta">
                                                    <span>App in the works</span>
                                                    <p>Laracon July 19th + <a href="https://v3when.com" target="_blank" class="action-link">V3When</a> GOOOD STUFF!</p>
                                                </div>
                                            </div>
                                            <div class="media-flex">
                                                <div class="icon-wrap is-danger is-dark-bg-3 is-dark-card-bordered">
                                                    <i data-feather="alert-circle"></i>
                                                </div>
                                                <div class="flex-meta">
                                                    <span>Spotify Premium Required</span>
                                                    <p>bummer.. but we're doing a Spotify Gift Card Giveway! <a class="action-link">Check Giveaway</a> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            </div>

                        </div>

                    </div>

                </div>

