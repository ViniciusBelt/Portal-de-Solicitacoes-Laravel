@include('layouts.app')
    <div class="col-lg-12">
        <div class="card chat-app">
            <div id="plist" class="people-list">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <select name="usuarios" id="usuarios" class="form-control select2">
                        <option value="" disabled selected>Buscar...</option>
                        @foreach ($usuarios as $users)
                        <option value="{{$users->id}}">{{$users->nome}}</option>   
                        @endforeach
                    </select>
                </div>
                <ul class="list-unstyled chat-list mt-2 mb-0">
                    @foreach ($usuarios as $users)
                    <form action="{{route('setChat')}}" id="formSetChat{{$users->id}}">
                        <a onclick="document.getElementById('formSetChat{{$users->id}}').submit();">
                        <li class="clearfix">
                            <img src="https://cdn-icons-png.flaticon.com/512/17/17004.png" alt="avatar">
                            <div class="about">
                                <div class="name">{{$users->nome}}</div>
                                <div class="status"> <i class="fa fa-circle @if($users->id_acesso != 4) online @else offline @endif"></i> {{$users->id_acesso != 4 ? 'Ativo' : 'Inativo'}} </div>                                            
                                <input type="hidden" id="userId" name="userId" value="{{$users->id}}">
                            </div>
                        </li>
                        </a>
                    </form>
                    @endforeach
                </ul>
            </div>
            <div class="chat">
                @if ($chatAtual)
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img src="https://cdn-icons-png.flaticon.com/512/17/17004.png" alt="avatar">
                            </a>
                            <div class="chat-about">
                                <h6 class="m-b-0">{{$userChat->nome}}</h6>
                                <small>{{$userChat->id_acesso != 4 ? 'Ativo' : 'Inativo'}}</small>
                            </div>
                        </div>
                        <div class="col-lg-6 hidden-sm text-right">
                            <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                        </div>
                    </div>
                </div>
                <div class="chat-history">
                    <ul class="m-b-0">
                        @foreach ($mensagem as $msg)
                        <li class="clearfix">
                            <div class="message-data @if($msg->id_remetente == Auth::user()->id) text-right @endif">
                                <span class="message-data-time"><br>{{date_format(date_create($msg->data_criacao), 'H:i')}}<br>{{date_format(date_create($msg->data_criacao), 'd/m/Y')}}</span>
                            </div>
                            <div style="min-width: 20px; max-width: 16rem" class="message @if($msg->id_remetente == Auth::user()->id) my-message float-right @else other-message @endif"> {{$msg->mensagem}} </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <form action="{{route('send')}}">
                    @csrf
                    <input type="hidden" name="chatAtual" id="chatAtual" value="{{$chatAtual->id}}">
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <textarea class="form-control" placeholder="Mensagem..." id="mensagem" name="mensagem" rows="2" maxlength="200" required></textarea>                               
                            <button type="submit" class="btn btn-light input-group-text">
                                   <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            </a>
                            <div class="chat-about">
                            </div>
                        </div>
                        <div class="col-lg-6 hidden-sm text-right">
                        </div>
                    </div>
                </div>
                <div class="chat-history">
                    <ul class="m-b-0">
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
@include('layouts.final')
<style type="text/css">
    .card {
        background: #fff;
        transition: .5s;
        border: 0;
        margin-bottom: 30px;
        border-radius: .55rem;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
    }
    .chat-app .people-list {
        width: 280px;
        position: absolute;
        left: 0;
        top: 0;
        padding: 20px;
        z-index: 7
    }

    .chat-app .chat {
        margin-left: 280px;
        border-left: 1px solid #eaeaea
    }

    @media all and (max-width: 30px) {
        .chat-history{
            overflow:auto; 
        }
    }

    .people-list {
        -moz-transition: .5s;
        -o-transition: .5s;
        -webkit-transition: .5s;
        transition: .5s
    }

    .people-list .chat-list li {
        padding: 10px 15px;
        list-style: none;
        border-radius: 3px
    }

    .people-list .chat-list li:hover {
        background: #efefef;
        cursor: pointer
    }

    .people-list .chat-list li.active {
        background: #efefef
    }

    .people-list .chat-list li .name {
        font-size: 15px
    }

    .people-list .chat-list img {
        width: 45px;
        border-radius: 50%
    }

    .people-list img {
        float: left;
        border-radius: 50%
    }

    .people-list .about {
        float: left;
        padding-left: 8px
    }

    .people-list .status {
        color: #999;
        font-size: 13px
    }

    .chat .chat-header {
        padding: 15px 20px;
        border-bottom: 2px solid #f4f7f6
    }

    .chat .chat-header img {
        float: left;
        border-radius: 40px;
        width: 40px
    }

    .chat .chat-header .chat-about {
        float: left;
        padding-left: 10px
    }

    .chat .chat-history {
        padding: 20px;
        border-bottom: 2px solid #fff;
        height: 400px;
        overflow: auto
    }

    .chat .chat-history ul {
        padding: 0
    }

    .chat .chat-history ul li {
        list-style: none;
        margin-bottom: 30px
    }

    .chat .chat-history ul li:last-child {
        margin-bottom: 0px
    }

    .chat .chat-history .message-data {
        margin-bottom: 15px
    }

    .chat .chat-history .message-data img {
        border-radius: 40px;
        width: 40px
    }

    .chat .chat-history .message-data-time {
        color: #434651;
        padding-left: 6px
    }

    .chat .chat-history .message {
        color: #444;
        padding: 18px 20px;
        line-height: 26px;
        font-size: 16px;
        border-radius: 7px;
        display: inline-block;
        position: relative
    }

    .chat .chat-history .message:after {
        bottom: 100%;
        left: 7%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #fff;
        border-width: 10px;
        margin-left: -10px
    }

    .chat .chat-history .my-message {
        background: #efefef
    }

    .chat .chat-history .my-message:after {
        bottom: 100%;
        left: 30px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #efefef;
        border-width: 10px;
        margin-left: -10px
    }

    .chat .chat-history .other-message {
        background: #e8f1f3;
        text-align: right
    }

    .chat .chat-history .other-message:after {
        border-bottom-color: #e8f1f3;
        left: 93%
    }

    .chat .chat-message {
        padding: 20px
    }

    .online,
    .offline,
    .me {
        margin-right: 2px;
        font-size: 8px;
        vertical-align: middle
    }

    .online {
        color: #86c541
    }

    .offline {
        color: #e47297
    }

    .me {
        color: #1d8ecd
    }

    .float-right {
        float: right
    }

    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0
    }

    @media only screen and (max-width: 767px) {
        .chat-app .people-list {
            height: 465px;
            width: 100%;
            overflow-x: auto;
            background: #fff;
            left: -400px;
            display: none
        }
        .chat-app .people-list.open {
            left: 0
        }
        .chat-app .chat {
            margin: 0
        }
        .chat-app .chat .chat-header {
            border-radius: 0.55rem 0.55rem 0 0
        }
        .chat-app .chat-history {
            height: 300px;
            overflow-x: auto
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 992px) {
        .chat-app .chat-list {
            height: 650px;
            overflow-x: auto
        }
        .chat-app .chat-history {
            height: 600px;
            overflow-x: auto
        }
    }

    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
        .chat-app .chat-list {
            height: 480px;
            overflow-x: auto
        }
        .chat-app .chat-history {
            height: calc(100vh - 350px);
            overflow-x: auto
        }
    }
</style>
<script>
    $(".chat-history").animate({
        scrollTop: $('.chat-history').get(0).scrollHeight
    }, 1);
</script>