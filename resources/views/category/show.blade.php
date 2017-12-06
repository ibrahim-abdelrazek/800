<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class=""> doctor </h3>
                </div>

                <div class="panel-body">

                    <div class="show">
                        <span>Name: </span>
                        <span class="value">{{ $category->name}}  </span>
                    </div>

                    <div class="show">
                        <span>Parent: </span>
                        <span class="value"> {{\App\Category::where("id",$subcategory1->parent)->value('name') }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
