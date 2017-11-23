<div class="row">
    <div class="business-card">
        <div class="media">
            <div class="media-left col-md-4">
                @if(!empty($person->photo))
                    <img class="media-object img-circle profile-img" src="{{ asset($person->photo) }}">
                @else
                    <img class="media-object img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                @endif
            </div>
            @if(!isset($person->nurses))
            <div class="media-body col-md-8">
                <h2 class="media-heading">{{$person->name}}</h2>
                <div class="job">{{$person->job_title}}</div>
                <div class="mail"><a href="mailto:{{$person->email}}">{{$person->email}}</a> </div>
                <div class="fa-phone"><a href="tel:{{$person->phone}}">{{$person->phone}}</a> </div>
            </div>
            @else
            <div class="media-body col-md-4">
                <h2 class="media-heading">{{$person->name}}</h2>
                <div class="job">{{$person->job_title}}</div>
                <div class="mail"><a href="mailto:{{$person->email}}">{{$person->email}}</a> </div>
                <div class="fa-phone"><a href="tel:{{$person->phone}}">{{$person->phone}}</a> </div>
            </div>
            <div class="media-body col-md-4">
                <h5>Nurses Associated</h5>
                @foreach($person->nurses as $nurse)
                <div >{{$nurse->name}}</div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>