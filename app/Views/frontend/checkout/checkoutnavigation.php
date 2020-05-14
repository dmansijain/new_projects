<div class="navbar" ng-controller="navCtrl">
                                <div class="navbar-inner">
								
                                    <ul class="nav nav-pills">
                                        <li ng-if="$route.current.activetab == 'billing' || $route.current.activetab == 'payment'"><a href="billing/{{eventslug}}"  ng-class="{active: $route.current.activetab == 'billing'}">
                                                <button class="btn primary-btn small-btn">1</button>
                                                <p class="t-title">Billing</p>
                                            </a></li>
										<li ng-if="$route.current.activetab != 'billing' && $route.current.activetab != 'payment'"><a href="javascript:void(0);"  ng-class="{active: $route.current.activetab == 'billing'}">
                                                <button class="btn primary-btn small-btn">1</button>
                                                <p class="t-title">Billing</p>
                                            </a></li>
                                        <li ng-if="$route.current.activetab == 'payment'"><a href="payment/{{eventslug}}/{{orderID}}" id="payment"  ng-class="{active: $route.current.activetab == 'payment'}">
                                                <button class="btn primary-btn small-btn">2</button>
                                                <p class="t-title">Payment</p>
                                            </a></li>
										<li ng-if="$route.current.activetab != 'payment'"><a href="javascript::void(0);" id="payment"  ng-class="{active: $route.current.activetab == 'payment'}">
                                                <button class="btn primary-btn small-btn">2</button>
                                                <p class="t-title">Payment</p>
                                            </a></li>
                                        <li ng-if="$route.current.activetab != 'billing' && $route.current.activetab != 'payment'"><a href="agreements/{{eventslug}}/{{orderID}}" id="agreements"  ng-class="{active: $route.current.activetab == 'agreements'}">
                                                <button class="btn primary-btn small-btn">3</button>
                                                <p class="t-title">Agreements</p>
                                            </a></li>
										<li ng-if="$route.current.activetab == 'billing' || $route.current.activetab == 'payment'"><a href="javascript::void(0);" id="agreements"  ng-class="{active: $route.current.activetab == 'agreements'}">
                                                <button class="btn primary-btn small-btn">3</button>
                                                <p class="t-title">Agreements</p>
                                            </a></li>
                                        <li ng-if="$route.current.activetab != 'billing' && $route.current.activetab != 'payment' && $route.current.activetab != 'agreements'"><a href="healthinfo/{{eventslug}}/{{orderID}}" id="healthinfo"  ng-class="{active: $route.current.activetab == 'healthinfo'}">
                                                <button class="btn primary-btn small-btn">4</button>
                                                <p class="t-title">health info</p>
                                            </a></li>
										<li ng-if="$route.current.activetab == 'billing' || $route.current.activetab == 'payment' || $route.current.activetab == 'agreements'"><a href="javascript::void(0);" id="healthinfo"  ng-class="{active: $route.current.activetab == 'healthinfo'}">
                                                <button class="btn primary-btn small-btn">4</button>
                                                <p class="t-title">health info</p>
                                            </a></li>
                                        <li ng-if="$route.current.activetab != 'billing'  && $route.current.activetab != 'payment' && $route.current.activetab != 'agreements' && $route.current.activetab != 'healthinfo'"><a href="notifications/{{eventslug}}/{{orderID}}" id="notifications"  ng-class="{active: $route.current.activetab == 'notifications'}">
                                                <button class="btn primary-btn small-btn">5</button>
                                                <p class="t-title">notifications</p>
                                            </a></li>
										<li ng-if="$route.current.activetab == 'billing'  || $route.current.activetab == 'payment' || $route.current.activetab == 'agreements' || $route.current.activetab == 'healthinfo'"><a href="javascript::void(0);" id="notifications"  ng-class="{active: $route.current.activetab == 'notifications'}">
                                                <button class="btn primary-btn small-btn">5</button>
                                                <p class="t-title">notifications</p>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>