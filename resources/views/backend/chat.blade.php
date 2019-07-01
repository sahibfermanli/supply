@extends('backend.app')
@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="layaut">
            <div class="sidebar">
                <div class="container">
                    <div class="tab-content">
                        <!-- Start of Discussions -->
                        <div class="tab-pane   active" id="conversations" role="tabpanel">
                            <div class="top">
                                <form>
                                    <input type="search" class="form-control" placeholder="Search">
                                    <button type="submit" class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-search"><g data-name="Layer 2"><g data-name="search"><rect width="24" height="24" opacity="0"></rect><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"></path></g></g></svg></button>
                                </form>

                            </div>
                            <div class="middle">
                                <h4>Discussions</h4>
                                <button type="button" class="btn round" data-toggle="modal" data-target="#compose"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-edit-2"><g data-name="Layer 2"><g data-name="edit-2"><rect width="24" height="24" opacity="0"></rect><path d="M19 20H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2z"></path><path d="M5 18h.09l4.17-.38a2 2 0 0 0 1.21-.57l9-9a1.92 1.92 0 0 0-.07-2.71L16.66 2.6A2 2 0 0 0 14 2.53l-9 9a2 2 0 0 0-.57 1.21L4 16.91a1 1 0 0 0 .29.8A1 1 0 0 0 5 18zM15.27 4L18 6.73l-2 1.95L13.32 6z"></path></g></g></svg></button>
                                <hr>
                                <ul class="nav discussions" role="tablist">
                                    <li>
                                        <a href="#chat1" class="filter direct" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="false">
                                            <div class="content">
                                                <div class="headline">
                                                    <h5>Ham Chuwon</h5>
                                                    <span>Today</span>
                                                </div>
                                                <p>Please review and sign the binding agreement.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat1" class="filter direct" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="false">
                                            <div class="content">
                                                <div class="headline">
                                                    <h5>Quincy Hensen</h5>
                                                    <span>Today</span>
                                                </div>
                                                <p>Additional information about the previous clients.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat1" class="filter direct" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="false">
                                            <div class="content">
                                                <div class="headline">
                                                    <h5>Mark Hog</h5>
                                                    <span>Feb 23</span>
                                                </div>
                                                <p>I'm looking to get a quote for the move from LA to NY.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat1" class="filter direct" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="false">
                                            <div class="content">
                                                <div class="headline">
                                                    <h5>Sanne Viscaal</h5>
                                                    <span>Jan 18</span>
                                                </div>
                                                <p>My delivery address is pending final confirmation.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat1" class="filter direct active" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="true">
                                            \                                        <div class="content">
                                                <div class="headline">
                                                    <h5>Alex Just</h5>
                                                    <span>May 2</span>
                                                </div>
                                                <p>Sending all the requested insurance documents.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat2" class="filter groups" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat2" aria-selected="false" style="display: none;">
                                            <div class="content">
                                                <div class="headline">
                                                    <img src="dist/img/avatars/avatar-group-1.jpg" alt="avatar">
                                                    <h5>The Musketeers</h5>
                                                    <span>Today</span>
                                                </div>
                                                <p>Please review and sign the binding agreement.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat2" class="filter groups" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat2" aria-selected="false" style="display: none;">
                                            <div class="content">
                                                <div class="headline">
                                                    <img src="dist/img/avatars/avatar-group-2.jpg" alt="avatar">
                                                    <h5>Watts Up</h5>
                                                    <span>Today</span>
                                                </div>
                                                <p>Additional information about the previous clients.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat2" class="filter groups" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat2" aria-selected="false" style="display: none;">
                                            <div class="content">
                                                <div class="headline">
                                                    <img src="dist/img/avatars/avatar-group-3.jpg" alt="avatar">
                                                    <h5>Memes</h5>
                                                    <span>Feb 23</span>
                                                </div>
                                                <p>I'm looking to get a quote for the move from LA to NY.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat2" class="filter groups" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat2" aria-selected="false" style="display: none;">
                                            <div class="content">
                                                <div class="headline">
                                                    <img src="dist/img/avatars/avatar-group-4.jpg" alt="avatar">
                                                    <h5>Supernovas</h5>
                                                    <span>Jan 18</span>
                                                </div>
                                                <p>My delivery address is pending final confirmation.</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#chat2" class="filter groups" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat2" aria-selected="false" style="display: none;">
                                            <div class="content">
                                                <div class="headline">
                                                    <img src="dist/img/avatars/avatar-group-5.jpg" alt="avatar">
                                                    <h5>Squad Ghouls</h5>
                                                    <span>May 2</span>
                                                </div>
                                                <p>Sending all the requested insurance documents.</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End of Discussions -->
                        <!-- Start of Friends -->
                        <div class="tab-pane fade" id="friends" role="tabpanel">
                            <div class="top">
                                <form>
                                    <input type="search" class="form-control" placeholder="Search">
                                    <button type="submit" class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-search"><g data-name="Layer 2"><g data-name="search"><rect width="24" height="24" opacity="0"></rect><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"></path></g></g></svg></button>
                                </form>
                            </div>
                            <div class="middle">
                                <h4>Friends</h4>
                                <hr>
                                <ul class="users">
                                    <li>
                                        <a href="#">
                                            <div class="status online"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Ham Chuwon</h5>
                                                <span>Florida, US</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status offline"><img src="dist/img/avatars/avatar-male-2.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Quincy Hensen</h5>
                                                <span>Shanghai, China</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status online"><img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Mark Hog</h5>
                                                <span>Olso, Norway</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status offline"><img src="dist/img/avatars/avatar-male-4.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Sanne Viscaal</h5>
                                                <span>Helena, Montana</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status offline"><img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Alex Just</h5>
                                                <span>London, UK</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status online"><img src="dist/img/avatars/avatar-male-6.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Arturo Thomas</h5>
                                                <span>Vienna, Austria</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status offline"><img src="dist/img/avatars/avatar-female-1.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Victoria Garner</h5>
                                                <span>Chisinau, Moldova</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status offline"><img src="dist/img/avatars/avatar-female-2.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Maria Baron</h5>
                                                <span>Indore, India</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="status online"><img src="dist/img/avatars/avatar-female-3.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                            <div class="content">
                                                <h5>Sara Koch</h5>
                                                <span>Sofia, BG</span>
                                            </div>
                                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End of Friends -->
                        <!-- Start of Notifications -->
                        <div class="tab-pane fade" id="notifications" role="tabpanel">
                            <div class="top">
                                <form>
                                    <input type="search" class="form-control" placeholder="Search">
                                    <button type="submit" class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-search"><g data-name="Layer 2"><g data-name="search"><rect width="24" height="24" opacity="0"></rect><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"></path></g></g></svg></button>
                                </form>
                            </div>
                            <div class="middle">
                                <h4>Notifications</h4>
                                <hr>
                                <ul class="notifications">
                                    <li>
                                        <div class="round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person-done"><g data-name="Layer 2"><g data-name="person-done"><rect width="24" height="24" opacity="0"></rect><path d="M21.66 4.25a1 1 0 0 0-1.41.09l-1.87 2.15-.63-.71a1 1 0 0 0-1.5 1.33l1.39 1.56a1 1 0 0 0 .75.33 1 1 0 0 0 .74-.34l2.61-3a1 1 0 0 0-.08-1.41z"></path><path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1"></path></g></g></svg></div>
                                        <p>Quincy has joined to <strong>Squad Ghouls</strong> group.</p>
                                    </li>
                                    <li>
                                        <div class="round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-lock"><g data-name="Layer 2"><g data-name="lock"><rect width="24" height="24" opacity="0"></rect><circle cx="12" cy="15" r="1"></circle><path d="M17 8h-1V6.11a4 4 0 1 0-8 0V8H7a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3zm-7-1.89A2.06 2.06 0 0 1 12 4a2.06 2.06 0 0 1 2 2.11V8h-4zM12 18a3 3 0 1 1 3-3 3 3 0 0 1-3 3z"></path></g></g></svg></div>
                                        <p>You need change your password for security reasons.</p>
                                    </li>
                                    <li>
                                        <div class="round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-attach"><g data-name="Layer 2"><g data-name="attach"><rect width="24" height="24" opacity="0"></rect><path d="M9.29 21a6.23 6.23 0 0 1-4.43-1.88 6 6 0 0 1-.22-8.49L12 3.2A4.11 4.11 0 0 1 15 2a4.48 4.48 0 0 1 3.19 1.35 4.36 4.36 0 0 1 .15 6.13l-7.4 7.43a2.54 2.54 0 0 1-1.81.75 2.72 2.72 0 0 1-1.95-.82 2.68 2.68 0 0 1-.08-3.77l6.83-6.86a1 1 0 0 1 1.37 1.41l-6.83 6.86a.68.68 0 0 0 .08.95.78.78 0 0 0 .53.23.56.56 0 0 0 .4-.16l7.39-7.43a2.36 2.36 0 0 0-.15-3.31 2.38 2.38 0 0 0-3.27-.15L6.06 12a4 4 0 0 0 .22 5.67 4.22 4.22 0 0 0 3 1.29 3.67 3.67 0 0 0 2.61-1.06l7.39-7.43a1 1 0 1 1 1.42 1.41l-7.39 7.43A5.65 5.65 0 0 1 9.29 21z"></path></g></g></svg></div>
                                        <p>Mark attached the file <strong>workbox.js</strong>.</p>
                                    </li>
                                    <li>
                                        <div class="icon round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-gift"><g data-name="Layer 2"><g data-name="gift"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M4.64 15.27v4.82a.92.92 0 0 0 .92.91h5.62v-5.73z"></path><path d="M12.82 21h5.62a.92.92 0 0 0 .92-.91v-4.82h-6.54z"></path><path d="M20.1 7.09h-1.84a2.82 2.82 0 0 0 .29-1.23A2.87 2.87 0 0 0 15.68 3 4.21 4.21 0 0 0 12 5.57 4.21 4.21 0 0 0 8.32 3a2.87 2.87 0 0 0-2.87 2.86 2.82 2.82 0 0 0 .29 1.23H3.9c-.5 0-.9.59-.9 1.31v3.93c0 .72.4 1.31.9 1.31h7.28V7.09h1.64v6.55h7.28c.5 0 .9-.59.9-1.31V8.4c0-.72-.4-1.31-.9-1.31zm-11.78 0a1.23 1.23 0 1 1 0-2.45c1.4 0 2.19 1.44 2.58 2.45zm7.36 0H13.1c.39-1 1.18-2.45 2.58-2.45a1.23 1.23 0 1 1 0 2.45z"></path></g></g></svg></div>
                                        <p>Sara has a birthday today. Wish her all the best.</p>
                                    </li>
                                    <li>
                                        <div class="round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
                                        <p>Sanne has accepted your friend request.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End of Notifications -->
                        <!-- Start of Settings -->
                        <div class="settings tab-pane fade" id="settings" role="tabpanel">
                            <div class="user">
                                <label>
                                    <input type="file">
                                    <img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar">
                                </label>
                                <div class="content">
                                    <h5>Ham Chuwon</h5>
                                    <span>Florida, US</span>
                                </div>
                            </div>
                            <h4>Settings</h4>
                            <ul id="preferences">
                                <!-- Start of Account -->
                                <li>
                                    <a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#account" aria-controls="account">
                                        <div class="title">
                                            <h5>Account</h5>
                                            <p>Update your profile details</p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-forward"><g data-name="Layer 2"><g data-name="arrow-ios-forward"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"></path></g></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-downward"><g data-name="Layer 2"><g data-name="arrow-ios-downward"><rect width="24" height="24" opacity="0"></rect><path d="M12 16a1 1 0 0 1-.64-.23l-6-5a1 1 0 1 1 1.28-1.54L12 13.71l5.36-4.32a1 1 0 0 1 1.41.15 1 1 0 0 1-.14 1.46l-6 4.83A1 1 0 0 1 12 16z"></path></g></g></svg>
                                    </a>
                                    <div class="content collapse" id="account" data-parent="#preferences">
                                        <div class="inside">
                                            <form class="account">
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input type="text" class="form-control" placeholder="First name" value="Ham">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input type="text" class="form-control" placeholder="Last name" value="Chuwon">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <input type="email" class="form-control" placeholder="Enter your email address" value="hamchuwon@gmail.com">
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" placeholder="Enter your password" value="123456">
                                                </div>
                                                <div class="form-group">
                                                    <label>Biography</label>
                                                    <textarea class="form-control" placeholder="Tell us a little about yourself"></textarea>
                                                </div>
                                                <button type="submit" class="btn primary">Save settings</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <!-- End of Account -->
                                <!-- Start of Privacy & Safety -->
                                <li>
                                    <a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#privacy" aria-controls="privacy">
                                        <div class="title">
                                            <h5>Privacy &amp; Safety</h5>
                                            <p>Control your privacy settings</p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-forward"><g data-name="Layer 2"><g data-name="arrow-ios-forward"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"></path></g></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-downward"><g data-name="Layer 2"><g data-name="arrow-ios-downward"><rect width="24" height="24" opacity="0"></rect><path d="M12 16a1 1 0 0 1-.64-.23l-6-5a1 1 0 1 1 1.28-1.54L12 13.71l5.36-4.32a1 1 0 0 1 1.41.15 1 1 0 0 1-.14 1.46l-6 4.83A1 1 0 0 1 12 16z"></path></g></g></svg>
                                    </a>
                                    <div class="content collapse" id="privacy" data-parent="#preferences">
                                        <div class="inside">
                                            <ul class="options">
                                                <li>
                                                    <div class="headline">
                                                        <h5>Safe Mode</h5>
                                                        <label class="switch">
                                                            <input type="checkbox" checked="">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                                <li>
                                                    <div class="headline">
                                                        <h5>History</h5>
                                                        <label class="switch">
                                                            <input type="checkbox" checked="">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                                <li>
                                                    <div class="headline">
                                                        <h5>Camera</h5>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                                <li>
                                                    <div class="headline">
                                                        <h5>Microphone</h5>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <!-- End of Privacy & Safety -->
                                <!-- Start of Notifications -->
                                <li>
                                    <a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#alerts" aria-controls="alerts">
                                        <div class="title">
                                            <h5>Notifications</h5>
                                            <p>Turn notifications on or off</p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-forward"><g data-name="Layer 2"><g data-name="arrow-ios-forward"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"></path></g></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-downward"><g data-name="Layer 2"><g data-name="arrow-ios-downward"><rect width="24" height="24" opacity="0"></rect><path d="M12 16a1 1 0 0 1-.64-.23l-6-5a1 1 0 1 1 1.28-1.54L12 13.71l5.36-4.32a1 1 0 0 1 1.41.15 1 1 0 0 1-.14 1.46l-6 4.83A1 1 0 0 1 12 16z"></path></g></g></svg>
                                    </a>
                                    <div class="content collapse" id="alerts" data-parent="#preferences">
                                        <div class="inside">
                                            <ul class="options">
                                                <li>
                                                    <div class="headline">
                                                        <h5>Pop-up</h5>
                                                        <label class="switch">
                                                            <input type="checkbox" checked="">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                                <li>
                                                    <div class="headline">
                                                        <h5>Vibrate</h5>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                                <li>
                                                    <div class="headline">
                                                        <h5>Sound</h5>
                                                        <label class="switch">
                                                            <input type="checkbox" checked="">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                                <li>
                                                    <div class="headline">
                                                        <h5>Lights</h5>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <!-- End of Notifications -->
                                <!-- Start of Integrations -->
                                <li>
                                    <a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#integrations" aria-controls="integrations">
                                        <div class="title">
                                            <h5>Integrations</h5>
                                            <p>Sync your social accounts</p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-forward"><g data-name="Layer 2"><g data-name="arrow-ios-forward"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"></path></g></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-downward"><g data-name="Layer 2"><g data-name="arrow-ios-downward"><rect width="24" height="24" opacity="0"></rect><path d="M12 16a1 1 0 0 1-.64-.23l-6-5a1 1 0 1 1 1.28-1.54L12 13.71l5.36-4.32a1 1 0 0 1 1.41.15 1 1 0 0 1-.14 1.46l-6 4.83A1 1 0 0 1 12 16z"></path></g></g></svg>
                                    </a>
                                    <div class="content collapse" id="integrations" data-parent="#preferences">
                                        <div class="inside">
                                            <ul class="integrations">
                                                <li>
                                                    <button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-google"><g data-name="Layer 2"><g data-name="google"><polyline points="0 0 24 0 24 24 0 24" opacity="0"></polyline><path d="M17.5 14a5.51 5.51 0 0 1-4.5 3.93 6.15 6.15 0 0 1-7-5.45A6 6 0 0 1 12 6a6.12 6.12 0 0 1 2.27.44.5.5 0 0 0 .64-.21l1.44-2.65a.52.52 0 0 0-.23-.7A10 10 0 0 0 2 12.29 10.12 10.12 0 0 0 11.57 22 10 10 0 0 0 22 12.52v-2a.51.51 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h5"></path></g></g></svg></button>
                                                    <div class="content">
                                                        <div class="headline">
                                                            <h5>Google</h5>
                                                            <label class="switch">
                                                                <input type="checkbox" checked="">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                        <span>Read, write, edit</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-facebook"><g data-name="Layer 2"><g data-name="facebook"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M17 3.5a.5.5 0 0 0-.5-.5H14a4.77 4.77 0 0 0-5 4.5v2.7H6.5a.5.5 0 0 0-.5.5v2.6a.5.5 0 0 0 .5.5H9v6.7a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-6.7h2.62a.5.5 0 0 0 .49-.37l.72-2.6a.5.5 0 0 0-.48-.63H13V7.5a1 1 0 0 1 1-.9h2.5a.5.5 0 0 0 .5-.5z"></path></g></g></svg></button>
                                                    <div class="content">
                                                        <div class="headline">
                                                            <h5>Facebook</h5>
                                                            <label class="switch">
                                                                <input type="checkbox" checked="">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                        <span>Read, write, edit</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-twitter"><g data-name="Layer 2"><g data-name="twitter"><polyline points="0 0 24 0 24 24 0 24" opacity="0"></polyline><path d="M8.08 20A11.07 11.07 0 0 0 19.52 9 8.09 8.09 0 0 0 21 6.16a.44.44 0 0 0-.62-.51 1.88 1.88 0 0 1-2.16-.38 3.89 3.89 0 0 0-5.58-.17A4.13 4.13 0 0 0 11.49 9C8.14 9.2 5.84 7.61 4 5.43a.43.43 0 0 0-.75.24 9.68 9.68 0 0 0 4.6 10.05A6.73 6.73 0 0 1 3.38 18a.45.45 0 0 0-.14.84A11 11 0 0 0 8.08 20"></path></g></g></svg></button>
                                                    <div class="content">
                                                        <div class="headline">
                                                            <h5>Twitter</h5>
                                                            <label class="switch">
                                                                <input type="checkbox">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                        <span>No permissions set</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-linkedin"><g data-name="Layer 2"><g data-name="linkedin"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M15.15 8.4a5.83 5.83 0 0 0-5.85 5.82v5.88a.9.9 0 0 0 .9.9h2.1a.9.9 0 0 0 .9-.9v-5.88a1.94 1.94 0 0 1 2.15-1.93 2 2 0 0 1 1.75 2v5.81a.9.9 0 0 0 .9.9h2.1a.9.9 0 0 0 .9-.9v-5.88a5.83 5.83 0 0 0-5.85-5.82z"></path><rect x="3" y="9.3" width="4.5" height="11.7" rx=".9" ry=".9"></rect><circle cx="5.25" cy="5.25" r="2.25"></circle></g></g></svg></button>
                                                    <div class="content">
                                                        <div class="headline">
                                                            <h5>LinkedIn</h5>
                                                            <label class="switch">
                                                                <input type="checkbox">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                        <span>No permissions set</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <!-- End of Integrations -->
                                <!-- Start of Appearance -->
                                <li>
                                    <a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#appearance" aria-controls="appearance">
                                        <div class="title">
                                            <h5>Appearance</h5>
                                            <p>Customize the look of Swipe</p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-forward"><g data-name="Layer 2"><g data-name="arrow-ios-forward"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"></path></g></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-downward"><g data-name="Layer 2"><g data-name="arrow-ios-downward"><rect width="24" height="24" opacity="0"></rect><path d="M12 16a1 1 0 0 1-.64-.23l-6-5a1 1 0 1 1 1.28-1.54L12 13.71l5.36-4.32a1 1 0 0 1 1.41.15 1 1 0 0 1-.14 1.46l-6 4.83A1 1 0 0 1 12 16z"></path></g></g></svg>
                                    </a>
                                    <div class="content collapse" id="appearance" data-parent="#preferences">
                                        <div class="inside">
                                            <ul class="options">
                                                <li>
                                                    <div class="headline">
                                                        <h5>Lights</h5>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round mode"></span>
                                                        </label>
                                                    </div>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <!-- End of Appearance -->
                            </ul>
                        </div>
                        <!-- End of Settings -->
                    </div>
                </div>
            </div>
            <div class="chat">
                <div class="tab-content">
                    <!-- Start of Chat Room -->
                    <div class="tab-pane  show active" id="chat1" role="tabpanel">
                        <div class="item">
                            <div class="content">
                                <div class="container">
                                    <div class="top">

                                        <ul>
                                            <li><button type="button" class="btn"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-video eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="video"><rect width="24" height="24" opacity="0"></rect>

                                                                    <path fill="#333333" d="M12.319,5.792L8.836,2.328C8.589,2.08,8.269,2.295,8.269,2.573v1.534C8.115,4.091,7.937,4.084,7.783,4.084c-2.592,0-4.7,2.097-4.7,4.676c0,1.749,0.968,3.337,2.528,4.146c0.352,0.194,0.651-0.257,0.424-0.529c-0.415-0.492-0.643-1.118-0.643-1.762c0-1.514,1.261-2.747,2.787-2.747c0.029,0,0.06,0,0.09,0.002v1.632c0,0.335,0.378,0.435,0.568,0.245l3.483-3.464C12.455,6.147,12.455,5.928,12.319,5.792 M8.938,8.67V7.554c0-0.411-0.528-0.377-0.781-0.377c-1.906,0-3.457,1.542-3.457,3.438c0,0.271,0.033,0.542,0.097,0.805C4.149,10.7,3.775,9.762,3.775,8.76c0-2.197,1.798-3.985,4.008-3.985c0.251,0,0.501,0.023,0.744,0.069c0.212,0.039,0.412-0.124,0.412-0.34v-1.1l2.646,2.633L8.938,8.67z M14.389,7.107c-0.34-0.18-0.662,0.244-0.424,0.529c0.416,0.493,0.644,1.118,0.644,1.762c0,1.515-1.272,2.747-2.798,2.747c-0.029,0-0.061,0-0.089-0.002v-1.631c0-0.354-0.382-0.419-0.558-0.246l-3.482,3.465c-0.136,0.136-0.136,0.355,0,0.49l3.482,3.465c0.189,0.186,0.568,0.096,0.568-0.245v-1.533c0.153,0.016,0.331,0.022,0.484,0.022c2.592,0,4.7-2.098,4.7-4.677C16.917,9.506,15.948,7.917,14.389,7.107 M12.217,15.238c-0.251,0-0.501-0.022-0.743-0.069c-0.212-0.039-0.411,0.125-0.411,0.341v1.101l-2.646-2.634l2.646-2.633v1.116c0,0.174,0.126,0.318,0.295,0.343c0.158,0.024,0.318,0.034,0.486,0.034c1.905,0,3.456-1.542,3.456-3.438c0-0.271-0.032-0.541-0.097-0.804c0.648,0.719,1.022,1.659,1.022,2.66C16.226,13.451,14.428,15.238,12.217,15.238"></path>

                                                                </g></g></svg></i></button></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="middle" id="scroll">
                                    <div class="container">
                                        <ul>
                                            <li>

                                                <div class="content">
                                                    <div class="message">
                                                        <span>Ali baba</span>
                                                        <div class="bubble">
                                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                        </div>
                                                    </div>
                                                    <span>07:30am</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content">
                                                    <div class="message">

                                                        <div class="bubble">
                                                            <p>Many desktop publishing packages.</p>
                                                        </div>
                                                    </div>
                                                    <span>11:56am</span>
                                                </div>
                                            </li>
                                            <li>

                                                <div class="content">
                                                    <div class="message">
                                                        <span>Ali baba</span>
                                                        <div class="bubble">
                                                            <div class="attachment">
                                                                <a href="#" class="round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></a>
                                                                <div class="meta">
                                                                    <a href="#"><h5>build-plugins.js</h5></a>
                                                                    <span>3kb</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span>01:03pm</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>It was popularised in the 1960s.</p>
                                                        </div>
                                                    </div>
                                                    <span>05:42pm</span>
                                                </div>
                                            </li>
                                            <li>

                                                <div class="content">
                                                    <div class="message">
                                                        <span>Ali baba</span>
                                                        <div class="bubble">
                                                            <p>It is a long established fact that a reader will be distracted.</p>
                                                        </div>
                                                    </div>
                                                    <span>08:20pm</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                                                        </div>
                                                    </div>
                                                    <span>10:15pm <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-done-all"><g data-name="Layer 2"><g data-name="done-all"><rect width="24" height="24" opacity="0"></rect><path d="M16.62 6.21a1 1 0 0 0-1.41.17l-7 9-3.43-4.18a1 1 0 1 0-1.56 1.25l4.17 5.18a1 1 0 0 0 .78.37 1 1 0 0 0 .83-.38l7.83-10a1 1 0 0 0-.21-1.41z"></path><path d="M21.62 6.21a1 1 0 0 0-1.41.17l-7 9-.61-.75-1.26 1.62 1.1 1.37a1 1 0 0 0 .78.37 1 1 0 0 0 .78-.38l7.83-10a1 1 0 0 0-.21-1.4z"></path><path d="M8.71 13.06L10 11.44l-.2-.24a1 1 0 0 0-1.43-.2 1 1 0 0 0-.15 1.41z"></path></g></g></svg></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content">
                                                    <div class="message">
                                                        <span>Ali baba</span>
                                                        <div class="bubble">
                                                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                                                        </div>
                                                    </div>
                                                    <span>10:15pm <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-done-all"><g data-name="Layer 2"><g data-name="done-all"><rect width="24" height="24" opacity="0"></rect><path d="M16.62 6.21a1 1 0 0 0-1.41.17l-7 9-3.43-4.18a1 1 0 1 0-1.56 1.25l4.17 5.18a1 1 0 0 0 .78.37 1 1 0 0 0 .83-.38l7.83-10a1 1 0 0 0-.21-1.41z"></path><path d="M21.62 6.21a1 1 0 0 0-1.41.17l-7 9-.61-.75-1.26 1.62 1.1 1.37a1 1 0 0 0 .78.37 1 1 0 0 0 .78-.38l7.83-10a1 1 0 0 0-.21-1.4z"></path><path d="M8.71 13.06L10 11.44l-.2-.24a1 1 0 0 0-1.43-.2 1 1 0 0 0-.15 1.41z"></path></g></g></svg></span>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="bottom">
                                        <form>
                                            <textarea class="form-control" placeholder="Type message..." rows="1"></textarea>
                                            <button type="submit" class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-paper-plane"><g data-name="Layer 2"><g data-name="paper-plane"><rect width="24" height="24" opacity="0"></rect><path d="M21 4a1.31 1.31 0 0 0-.06-.27v-.09a1 1 0 0 0-.2-.3 1 1 0 0 0-.29-.19h-.09a.86.86 0 0 0-.31-.15H20a1 1 0 0 0-.3 0l-18 6a1 1 0 0 0 0 1.9l8.53 2.84 2.84 8.53a1 1 0 0 0 1.9 0l6-18A1 1 0 0 0 21 4zm-4.7 2.29l-5.57 5.57L5.16 10zM14 18.84l-1.86-5.57 5.57-5.57z"></path></g></g></svg></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Start of Utility -->
                            <div class="utility">
                                <div class="container">
                                    <button type="button" class="close" data-utility="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-close"><g data-name="Layer 2"><g data-name="close"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"></path></g></g></svg></button>
                                    <button type="button" class="btn primary" data-toggle="modal" data-target="#compose">Add people</button>
                                    <ul class="nav" role="tablist">
                                        <li><a href="#users" class="active" data-toggle="tab" role="tab" aria-controls="users" aria-selected="true">Users</a></li>
                                        <li><a href="#files" data-toggle="tab" role="tab" aria-controls="files" aria-selected="false">Files</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- Start of Users -->
                                        <div class="tab-pane fade active show" id="users" role="tabpanel">
                                            <h4>Users</h4>
                                            <hr>
                                            <ul class="users">
                                                <li>
                                                    <div class="status online"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Ham Chuwon</h5>
                                                        <span>Florida, US</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status offline"><img src="dist/img/avatars/avatar-male-2.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Quincy Hensen</h5>
                                                        <span>Shanghai, China</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status online"><img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Mark Hog</h5>
                                                        <span>Olso, Norway</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status offline"><img src="dist/img/avatars/avatar-male-4.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Sanne Viscaal</h5>
                                                        <span>Helena, Montana</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status offline"><img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Alex Just</h5>
                                                        <span>London, UK</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status online"><img src="dist/img/avatars/avatar-male-6.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Arturo Thomas</h5>
                                                        <span>Vienna, Austria</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End of Users -->
                                        <!-- Start of Files -->
                                        <div class="tab-pane fade" id="files" role="tabpanel">
                                            <h4>Files</h4>
                                            <div class="upload">
                                                <label>
                                                    <input type="file">
                                                    <span>Drag &amp; drop files here</span>
                                                </label>
                                            </div>
                                            <ul class="files">
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>workbox.js</h5></a>
                                                        <span>2kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-2.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>bug_report</h5></a>
                                                        <span>1kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-briefcase"><g data-name="Layer 2"><g data-name="briefcase"><rect width="24" height="24" opacity="0"></rect><path d="M7 21h10V7h-1V5.5A2.5 2.5 0 0 0 13.5 3h-3A2.5 2.5 0 0 0 8 5.5V7H7zm3-15.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V7h-4z"></path><path d="M19 7v14a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3z"></path><path d="M5 7a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>nuget.zip</h5></a>
                                                        <span>7mb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-image-2"><g data-name="Layer 2"><g data-name="image-2"><rect width="24" height="24" opacity="0"></rect><path d="M18 3H6a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3zM8 7a1.5 1.5 0 1 1-1.5 1.5A1.5 1.5 0 0 1 8 7zm11 10.83A1.09 1.09 0 0 1 18 19H6l7.57-6.82a.69.69 0 0 1 .93 0l4.5 4.48z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-4.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>clearfix.jpg</h5></a>
                                                        <span>1kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>package</h5></a>
                                                        <span>4mb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-6.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>plugins.js</h5></a>
                                                        <span>3kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End of Files -->
                                    </div>
                                </div>
                            </div>
                            <!-- End of Utility -->
                        </div>
                    </div>
                    <!-- End of Chat Room -->
                    <!-- Start of Chat Room -->
                    <div class="tab-pane fade" id="chat2" role="tabpanel">
                        <div class="item">
                            <div class="content">
                                <div class="container">
                                    <div class="top">
                                        <div class="headline">
                                            <img src="dist/img/avatars/avatar-group-1.jpg" alt="avatar">
                                            <div class="content">
                                                <h5>The Musketeers</h5>
                                                <span>Group discussion</span>
                                            </div>
                                        </div>
                                        <ul>
                                            <li><button type="button" class="btn"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-video eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="video"><rect width="24" height="24" opacity="0"></rect><path d="M21 7.15a1.7 1.7 0 0 0-1.85.3l-2.15 2V8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-1.45l2.16 2a1.74 1.74 0 0 0 1.16.45 1.68 1.68 0 0 0 .69-.15 1.6 1.6 0 0 0 1-1.48V8.63A1.6 1.6 0 0 0 21 7.15z"></path></g></g></svg></i></button></li>
                                            <li><button type="button" class="btn"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-phone eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="phone"><rect width="24" height="24" opacity="0"></rect><path d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z"></path></g></g></svg></i></button></li>
                                            <li><button type="button" class="btn" data-toggle="modal" data-target="#compose"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person-add eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="person-add"><rect width="24" height="24" opacity="0"></rect><path d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z"></path><path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1"></path></g></g></svg></i></button></li>
                                            <li><button type="button" class="btn" data-utility="open"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-info eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="info"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"></path></g></g></svg></i></button></li>
                                            <li><button type="button" class="btn round" data-chat="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-back"><g data-name="Layer 2"><g data-name="arrow-ios-back"><rect width="24" height="24" transform="rotate(90 12 12)" opacity="0"></rect><path d="M13.83 19a1 1 0 0 1-.78-.37l-4.83-6a1 1 0 0 1 0-1.27l5-6a1 1 0 0 1 1.54 1.28L10.29 12l4.32 5.36a1 1 0 0 1-.78 1.64z"></path></g></g></svg></button></li>
                                            <li><button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></i></button>
                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-video"><g data-name="Layer 2"><g data-name="video"><rect width="24" height="24" opacity="0"></rect><path d="M21 7.15a1.7 1.7 0 0 0-1.85.3l-2.15 2V8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-1.45l2.16 2a1.74 1.74 0 0 0 1.16.45 1.68 1.68 0 0 0 .69-.15 1.6 1.6 0 0 0 1-1.48V8.63A1.6 1.6 0 0 0 21 7.15z"></path></g></g></svg>Video call</button>
                                                    <button type="button" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-phone"><g data-name="Layer 2"><g data-name="phone"><rect width="24" height="24" opacity="0"></rect><path d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z"></path></g></g></svg>Voice call</button>
                                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#compose"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person-add"><g data-name="Layer 2"><g data-name="person-add"><rect width="24" height="24" opacity="0"></rect><path d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z"></path><path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1"></path></g></g></svg>Add people</button>
                                                    <button type="button" class="dropdown-item" data-utility="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-info"><g data-name="Layer 2"><g data-name="info"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"></path></g></g></svg>Information</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="middle">
                                    <div class="container">
                                        <ul>
                                            <li>
                                                <img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar">
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                        </div>
                                                    </div>
                                                    <span>07:30am</span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar">
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>Many desktop publishing packages.</p>
                                                        </div>
                                                    </div>
                                                    <span>11:56am</span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar">
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>It has survived not only five centuries, but also the leap into electronic typesetting.</p>
                                                        </div>
                                                    </div>
                                                    <span>01:03pm</span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar">
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>It was popularised in the 1960s.</p>
                                                        </div>
                                                    </div>
                                                    <span>05:42pm</span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar">
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>It is a long established fact that a reader will be distracted.</p>
                                                        </div>
                                                    </div>
                                                    <span>08:20pm</span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar">
                                                <div class="content">
                                                    <div class="message">
                                                        <div class="bubble">
                                                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
                                                        </div>
                                                    </div>
                                                    <span>10:15pm <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-done-all"><g data-name="Layer 2"><g data-name="done-all"><rect width="24" height="24" opacity="0"></rect><path d="M16.62 6.21a1 1 0 0 0-1.41.17l-7 9-3.43-4.18a1 1 0 1 0-1.56 1.25l4.17 5.18a1 1 0 0 0 .78.37 1 1 0 0 0 .83-.38l7.83-10a1 1 0 0 0-.21-1.41z"></path><path d="M21.62 6.21a1 1 0 0 0-1.41.17l-7 9-.61-.75-1.26 1.62 1.1 1.37a1 1 0 0 0 .78.37 1 1 0 0 0 .78-.38l7.83-10a1 1 0 0 0-.21-1.4z"></path><path d="M8.71 13.06L10 11.44l-.2-.24a1 1 0 0 0-1.43-.2 1 1 0 0 0-.15 1.41z"></path></g></g></svg></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="bottom">
                                        <form>
                                            <textarea class="form-control" placeholder="Type message..." rows="1"></textarea>
                                            <button type="submit" class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-paper-plane"><g data-name="Layer 2"><g data-name="paper-plane"><rect width="24" height="24" opacity="0"></rect><path d="M21 4a1.31 1.31 0 0 0-.06-.27v-.09a1 1 0 0 0-.2-.3 1 1 0 0 0-.29-.19h-.09a.86.86 0 0 0-.31-.15H20a1 1 0 0 0-.3 0l-18 6a1 1 0 0 0 0 1.9l8.53 2.84 2.84 8.53a1 1 0 0 0 1.9 0l6-18A1 1 0 0 0 21 4zm-4.7 2.29l-5.57 5.57L5.16 10zM14 18.84l-1.86-5.57 5.57-5.57z"></path></g></g></svg></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Start of Utility -->
                            <div class="utility">
                                <div class="container">
                                    <button type="button" class="close" data-utility="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-close"><g data-name="Layer 2"><g data-name="close"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"></path></g></g></svg></button>
                                    <button type="button" class="btn primary" data-toggle="modal" data-target="#compose">Add people</button>
                                    <ul class="nav" role="tablist">
                                        <li><a href="#users2" class="active" data-toggle="tab" role="tab" aria-controls="users2" aria-selected="true">Users</a></li>
                                        <li><a href="#files2" data-toggle="tab" role="tab" aria-controls="files2" aria-selected="false">Files</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- Start of Users -->
                                        <div class="tab-pane fade active show" id="users2" role="tabpanel">
                                            <h4>Users</h4>
                                            <hr>
                                            <ul class="users">
                                                <li>
                                                    <div class="status online"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Ham Chuwon</h5>
                                                        <span>Florida, US</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status offline"><img src="dist/img/avatars/avatar-male-2.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Quincy Hensen</h5>
                                                        <span>Shanghai, China</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status online"><img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Mark Hog</h5>
                                                        <span>Olso, Norway</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status offline"><img src="dist/img/avatars/avatar-male-4.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Sanne Viscaal</h5>
                                                        <span>Helena, Montana</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status offline"><img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Alex Just</h5>
                                                        <span>London, UK</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="status online"><img src="dist/img/avatars/avatar-male-6.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
                                                    <div class="content">
                                                        <h5>Arturo Thomas</h5>
                                                        <span>Vienna, Austria</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End of Users -->
                                        <!-- Start of Files -->
                                        <div class="tab-pane fade" id="files2" role="tabpanel">
                                            <h4>Files</h4>
                                            <div class="upload">
                                                <label>
                                                    <input type="file">
                                                    <span>Drag &amp; drop files here</span>
                                                </label>
                                            </div>
                                            <ul class="files">
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>workbox.js</h5></a>
                                                        <span>2kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-2.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>bug_report</h5></a>
                                                        <span>1kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-briefcase"><g data-name="Layer 2"><g data-name="briefcase"><rect width="24" height="24" opacity="0"></rect><path d="M7 21h10V7h-1V5.5A2.5 2.5 0 0 0 13.5 3h-3A2.5 2.5 0 0 0 8 5.5V7H7zm3-15.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V7h-4z"></path><path d="M19 7v14a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3z"></path><path d="M5 7a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>nuget.zip</h5></a>
                                                        <span>7mb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-image-2"><g data-name="Layer 2"><g data-name="image-2"><rect width="24" height="24" opacity="0"></rect><path d="M18 3H6a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3zM8 7a1.5 1.5 0 1 1-1.5 1.5A1.5 1.5 0 0 1 8 7zm11 10.83A1.09 1.09 0 0 1 18 19H6l7.57-6.82a.69.69 0 0 1 .93 0l4.5 4.48z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-4.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>clearfix.jpg</h5></a>
                                                        <span>1kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>package</h5></a>
                                                        <span>4mb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <ul class="avatars">
                                                        <li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
                                                        <li><a href="#"><img src="dist/img/avatars/avatar-male-6.jpg" alt="avatar"></a></li>
                                                    </ul>
                                                    <div class="meta">
                                                        <a href="#"><h5>plugins.js</h5></a>
                                                        <span>3kb</span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item">Edit</button>
                                                            <button type="button" class="dropdown-item">Share</button>
                                                            <button type="button" class="dropdown-item">Delete</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End of Files -->
                                    </div>
                                </div>
                            </div>
                            <!-- End of Utility -->
                        </div>
                    </div>
                    <!-- End of Chat Room -->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /page content -->


@endsection

@section('css')
    <link rel="stylesheet" href="/css/swipe.css">
@endsection

@section('js')

@endsection
