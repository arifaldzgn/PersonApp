@extends('main.main')

@section('container')

<style>


    a {
        text-decoration: none; /* Remove underline */
        color: inherit; /* Inherit color from parent */
        }

        a:hover, a:focus {
            text-decoration: none; /* Remove underline on hover/focus */
            color: inherit; /* Inherit color from parent */
        }


    .card-transparent {
            border-radius: 12px;
            background: transparent;
            box-shadow: none;
            border: none;
            text-align: center;
        }

        .btn-transparent {
            color: #000;
            background: transparent;
            border: none;
            font-size: 32px; /* Increase the font size */
            padding: 10px 20px; /* Increase padding to make button bigger */
        }

        .btn-transparent:focus,
        .btn-transparent:hover {
            color: #ccc;
        }

    .card{
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
        transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
        padding: 14px 80px 18px 36px;
        cursor: pointer;
    }

    .card:hover{
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
    }

    .card h3{
        font-weight: 600;
    }

    .card img{
        position: absolute;
        top: 20px;
        right: 15px;
        max-height: 120px;
    }

    .card-1{
       background-image: url(https://ionicframework.com/img/getting-started/ionic-native-card.png);
        background-repeat: no-repeat;
        background-position: right;
        background-size: 80px;
    }

    .card-2{
        background-image: url(https://ionicframework.com/img/getting-started/components-card.png);
        background-repeat: no-repeat;
        background-position: right;
        background-size: 80px;
    }

    .card-3{
        background-image: url(https://ionicframework.com/img/getting-started/theming-card.png);
        background-repeat: no-repeat;
        background-position: right;
        background-size: 80px;
    }

    @media(max-width: 990px){
    .card{
        margin: 20px;
    }



}
</style>

<div class="container">
    <div class="row">
        @foreach ($data as $d)
        <div class="col-md-3">
            <div class="card card-1 mt-4">
                    <a href="muscle_group/{{$d->id}}">
                    <h3>{{ $d->name }}</h3>
                    <p>A curated set of   ES5/ES6/TypeScript wrappers for plugins to easily add any native functionality to your Ionic apps.</p>
                </div>
            </a>
            </div>
        @endforeach
        <div class="col-md-3">
            <div class="card card-transparent mt-4">
                <button class="btn btn-transparent" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>
    </div>
  </div>
@endsection
