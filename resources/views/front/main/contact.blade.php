<!-- contact -->
<div class="contact pad" id="contact">
    <div class="container">
        <!-- default heading -->
        <div class="default-heading">
            <!-- heading -->
            <h2>با ما در ارتباط باشید</h2>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <!-- contact item -->
                <div class="contact-item ">
                    <!-- big icon -->
                    <i class="fa fa-street-view"></i>
                    <!-- contact details  -->
                    <span class="contact-details">#30/67, 5th Street, Mega Market Circle, New Delhi - 625001</span>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <!-- contact item -->
                <div class="contact-item ">
                    <!-- big icon -->
                    <i class="fa fa-wifi"></i>
                    <!-- contact details  -->
                    <span class="contact-details">music.site@melodi.com</span>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <!-- contact item -->
                <div class="contact-item ">
                    <!-- big icon -->
                    <i class="fa fa-phone"></i>
                    <!-- contact details  -->
                    <span class="contact-details">555 555 5555</span>
                </div>
            </div>
        </div>
        <!-- form content -->
        <div class="form-content ">
            <!-- paragraph -->
            <p>آیا پیشنهاد یا انتقادی دارید؟ با ما در میان بگذارید!</p>
            <form action="{{ route('contact') }}" id="contactForm" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="name">نام:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="نام را وارد نمایید">
                            <span class="text-danger" role="alert">
                                @error('name')
                                <strong>{{ $message }}</strong>
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="email">ایمیل:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="ایمیل را وارد نمایید">
                            <span class="text-danger" role="alert">
                                @error('email')
                                <strong>{{ $message }}</strong>
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="phone">تلفن همراه:</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="تلفن همراه را وارد نمایید">
                            <span class="text-danger" role="alert">
                                @error('phone')
                                <strong>{{ $message }}</strong>
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="message">پیام شما:</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="9" placeholder="">{{ old('message') }}</textarea>
                            <span class="text-danger" role="alert">
                                @error('message')
                                <strong>{{ $message }}</strong>
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-theme">ارسال پیام</button>
                </div>
            </form>

        </div>

    </div>
</div>
<!-- contact end -->
