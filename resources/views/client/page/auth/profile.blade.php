@extends('client.layout')

@section('content')
    <div class="register-page section-padding-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-4">
                    <div class="my-account-menu mt-30">
                        <ul class="nav account-menu-list flex-column">
                            <li>
                                <a href="{{route('user.profile')}}" class="active"><i class="fa fa-user"></i> Hồ Sơ</a>
                            </li>
                            
                            <li>
                                <a href="{{route('ordered')}}" ><i class="fa fa-shopping-cart"></i> Đơn Đặt Hàng</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    <h3>Hồ sơ của tôi</h3>
                    <div class="mt-2 col-5">
                        <div class="form-group">
                            <div >Tên đăng nhập: <span class="form-text ">{{$user->name}}</span></div>
                            
                        </div>
                        <div class="form-group">
                            <div >Email: <span>{{$user->email}}</span></div>
                            
                        </div>
                        <div class="form-group">
                            <div >Số điện thoại: <span>{{$user->phoneNumber}}</span></div>
                        </div>
                    </div>
                    <div class="col-5">
                        <h5>Thay đổi mật khẩu</h5>
                        <form action="{{route('user.update.profile')}}" method="post">
                            @csrf
                            <div>
                                <label for="">Mật khẩu cũ</label>
                                <input type="password" class="form-control-sm " name="oldpassword">
                                @error('error')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="">Mật khẩu mới</label>
                                <input type="password" class="form-control-sm " name="newpassword">
                            </div>
                            <button type="submit" class="btn-sm btn-primary mt-2 rounded-2">Lưu</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    
@endsection
{{-- <div class=" "></div> --}}
