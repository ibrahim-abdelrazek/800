<div class="col-sm-6">
    <div class="business-card">
        <div class="media">
            <div class="media-left">
                <?php dd($person); ?>
                @if(isset($person->photo))
                    <img class="media-object img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                @else
                    <img class="media-object img-circle profile-img" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png">
                @endif
            </div>
            <div class="media-body">
                <h2 class="media-heading">$person->name</h2>
                <div class="job">$person->job_title</div>
                <div class="mail"><a href="mailto:{{$person->email}}">$person->email</a> </div>
                <div class="fa-phone"><a href="tel:{{$person->phone}}">$person->phone</a> </div>
            </div>
        </div>
    </div>
</div>