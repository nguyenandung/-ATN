@extends('admin.components.dashboard')
@section('style')
    <style>
        .single-slider {
   background-repeat: no-repeat;
   background-attachment: scroll;
   background-position: center center;
   background-size: cover;
   height: 738px;
   display: -webkit-box;
   display: -webkit-flex;
   display: -moz-flex;
   display: -ms-flexbox;
   display: flex;
   -webkit-box-align: center;
   -ms-flex-align: center;
   -webkit-align-items: center;
   -moz-align-items: center;
   align-items: center;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
   .single-slider {
      height: 610px;
   }
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
   .single-slider {
      height: 610px;
   }
}

@media only screen and (max-width: 767px) {
   .single-slider {
      height: 538px;
      background-position: left center;
   }
}

.slider-content {
   opacity: 1;
}

.slider-content .sub-title {
   font-size: 16px;
   color: #222222;
   font-family: 'Coiny', cursive;
   line-height: 20px;
   font-weight: 400;
   border-left: 2px solid #000000;
   padding-left: 8px;
   margin-bottom: 33px;
}

.slider-content .main-title {
   font-weight: 400;
   line-height: 63px;
   color: #323232;
   font-family: 'Coiny', cursive;
   font-size: 63px;
   text-transform: uppercase;
   margin-bottom: 24px;
}

@media only screen and (max-width: 767px) {
   .slider-content .main-title {
      font-size: 30px;
      line-height: 40px;
   }
}

.slider-content p {
   color: #323232;
   font-family: 'Coiny', cursive;
   font-weight: 300;
   font-size: 24px;
   line-height: 24px;
}

@media only screen and (max-width: 767px) {
   .slider-content p {
      font-size: 16px;
   }
}

.slider-content .slider-btn {
   padding-top: 30px;
}

@media only screen and (max-width: 767px) {
   .slider-content .slider-btn {
      padding-top: 20px;
   }
}

.slider-content .slider-btn li {
   margin-top: 10px;
   display: inline-block;
   margin-right: 15px;
}

.slider-content .slider-btn li:last-child {
   margin-right: 0;
}

.slider-content .slider-btn li .btn {
   height: 60px;
   line-height: 58px;
   padding: 0 45px;
   font-size: 15px;
}

@media only screen and (max-width: 767px) {
   .slider-content .slider-btn li .btn {
      height: 45px;
      line-height: 43px;
      padding: 0 35px;
   }
}
.slider-content .sub-title-right {
   padding: 0 8px 0 0;
   border-left: none;
   border-right: 2px solid #000;
}
    </style>
@endsection
@section('content')
<div>
    <h3>Preview</h3>
    <div class="single-slider swiper-slide animation-style-01" style="background-image: url('{{ asset('assets/imgs/KIDOLBanner.png') }}');">
                        <div class="container"  style="{{$slide->position == 'T' ? '' : 'text-align: right;'}}">
                            <div class="slider-content">
                                <h5 class="sub-title sub-title-right">{{$slide->sub_title}}</h5>
                                <h2 class="main-title">{{$slide->main_title}}</h2>
                                <ul class="slider-btn">
                                    <li><a href="" class="btn btn-round btn-primary">Bắt
                                            đầu mua sắm</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
</div>
<div class="row">

    <form action="" method="post">
        <div class="form-group ">
            <label class="form-label " for="">Tiêu đề chính</label>
            <input class="form-control " type="text" value="{{$slide->main_title}}" name="main_title">
        </div>
        <div class="form-group ">
            <label class="form-label " for="">Tiêu đề phụ</label>
            <input class="form-control " type="text" value="{{$slide->sub_title}}" name="sub_title">
        </div>
        <div class="form-group ">
            <label class="form-label " for="image">Hình ảnh</label>
            <input class="form-control " type="file" name="image" id="image">
        </div>
        <div class="form-group ">
            <label class="form-label " for="">Vị trí tiêu đề</label>
            <select class="form-select " name="postion" id="postion">
                <option value="T">Trái</option>
                <option value="P">Phải</option>
            </select>
        </div>
        <button class="btn-sm btn-primary " type="submit">Lưu</button>
    </form>
</div>
@endsection
@section('script')
    <script>
         document.querySelector('input[name="main_title"]').addEventListener('change', function(event) {
            let main_title = event.target.value;
            // console.log('Selected value:', selectedValue);
            // Thực hiện các hành động khác tại đây
            document.querySelector(".main-title").innerHTML = main_title;
        });
        document.querySelector('input[name="sub_title"]').addEventListener('change', function(event) {
            let sub_title = event.target.value;
            // console.log('Selected value:', selectedValue);
            // Thực hiện các hành động khác tại đây
            document.querySelector(".sub-title").innerHTML = sub_title;
        });
        document.querySelector('input[name="image"]').addEventListener('change', function(event) {
            console.log('hihi');
            let file = event.target.files[0];
            document.querySelector(".single-slider ").style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
        });
        document.querySelector('#postion').addEventListener('change', function(event) {
            // console.log('hihi');
            let selectedValue = event.target.value;
            // document.querySelector(".single-slider ").style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
            if(selectedValue == 'T'){
                document.querySelector('.single-slider>.container').style="";
                document.querySelector('.sub-title').classList.remove('sub-title-right');
            }
            else{
                document.querySelector('.single-slider>.container').style.textAlign="right";
                document.querySelector('.sub-title').classList.add('sub-title-right');
            }
        });
    </script>
@endsection