<div class="footer">
    <div class="row justify-content-sm-between justify-content-center align-items-center">
        <div class="col text-md-start">
            <p class="font-size-sm mb-0">
                &copy; Rey Howley. <span class="d-none d-sm-inline-block">2024. All rights reserved.</span>
            </p>
            <small class="text-muted" style="font-size: 10px;">
                Address: #101, Siri Appartments, Masapeta, Rayachoty, Annamayya Dist, Andhra Pradesh, IN, 516269 |
                Contact: +91 - 9052 11 44 88 | Email: hello@reyhowley.com
            </small>
        </div>
        <div class="col-auto">
            <div class="d-flex justify-content-end">
                <ul class="list-inline list-separator">
                    <li class="list-inline-item">
                        <a class="list-separator-link"
                            href="{{route('admin.business-settings.business-setup')}}">{{translate('messages.business_setup')}}</a>
                    </li>
                    <li class="list-inline-item">
                        <a class="list-separator-link"
                            href="{{route('admin.settings')}}">{{translate('messages.profile')}}</a>
                    </li>
                    <li class="list-inline-item">
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker h-unset btn btn-icon btn-ghost-secondary rounded-circle"
                                href="{{route('admin.dashboard')}}">
                                {{translate('messages.home')}}
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <label class="badge badge-soft-primary m-0"
                            title="Founders: Uday Reddy Saniki Reddy (Co-Founder), Ajay Reddy Madireddy (CEO | Co-Founder), Madhu Reddy KR (MD)">
                            ReyHowley v{{env('SOFTWARE_VERSION')}}
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>