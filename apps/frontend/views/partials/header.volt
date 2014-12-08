<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Netex Shop</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="">All</a></li>
                <li><a href="#">All Seasons</a></li>
                <li><a href="#">Winter</a></li>
                <li><a href="#">Summer</a></li>
            </ul>
            {{ form('', 'class':'navbar-form navbar-right', 'role' :'form') }}
            <div class="form-group">
                <div class="col-xs-10">
                    {{ text_field('search', 'value' : this.request.getPost('search'), 'class' : 'form-control', 'placeholder' : 'Find my tires...') }}
                </div>
                <button type="submit" name="find" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
            {{ endform() }}

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>