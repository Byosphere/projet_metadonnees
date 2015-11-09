@extends('master')

@section('content')
<div class="container">
    <div class="bloc">
        <h3>Envoyer une image sur le serveur</h3>
    </div>
</div>
<!--
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Ajouter une image</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ url('/upload') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT" />

                    <div class="form-group @if($errors->has('photo')) has-error  @endif">
                        <label class="col-md-4 control-label">Photo</label>
                        <div class="col-md-6">
                            <input type="file" name="photo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
-->
