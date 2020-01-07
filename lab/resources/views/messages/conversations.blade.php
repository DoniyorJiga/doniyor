@extends('layouts.chat')

@section('content')
    <div class="chat-history">
        <ul id="talkMessages">

            @foreach($messages as $message)
                @if($message->sender->id == auth()->user()->id)
                    <li class="clearfix" id="message-{{$message->id}}">
                        <div class="message-data align-right">
                            <span class="message-data-time" >{{$message->humans_time}} ago</span> &nbsp; &nbsp;
                            <span class="message-data-name" >{{$message->sender->name}}</span>
                            <a href="#" class="talkDeleteMessage" data-message-id="{{$message->id}}" title="Delete Message"><i class="fa fa-close"></i></a>
                        </div>
                        <div class="message other-message float-right">
                            {{$message->message}}
                        </div>
                    </li>
                @else

                    <li id="message-{{$message->id}}">
                        <div class="message-data">
                            <span class="message-data-name"> <a href="#" class="talkDeleteMessage" data-message-id="{{$message->id}}" title="Delete Messag"><i class="fa fa-close" style="margin-right: 3px;"></i></a>{{$message->sender->name}}</span>
                            <span class="message-data-time">{{$message->humans_time}} ago</span>
                        </div>
                        <div class="message my-message">
                            {{$message->message}}
                            @if(auth()->user()->lang != $u_lang)
                            <?php
                                echo "<div class='translate'>";
                                $yt_api_key = "trnsl.1.1.20180529T165301Z.0ffae5c035db47db.3e8829b83403ee7a5d920caea54dec0abb9242e6";
                                $yt_lang = $u_lang."-".auth()->user()->lang;
                                $yt_text = $message->message;
                                $yt_text = urlencode($yt_text);
                                $yt_link = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$yt_api_key."&text=".$yt_text."&lang=".$yt_lang;
                                $result = file_get_contents($yt_link);
                                $result = json_decode($result, true);
                                $en_test = $result['text'][0];
                                echo $en_test."</div>";
                            ?>
                            @endif
                        </div>
                    </li>
                @endif
            @endforeach


        </ul>

    </div> <!-- end chat-history -->

@endsection
