@if(count($posts) == 0 )
                @include('errors.NoResults' , ['msg1' => "Aucune Sujet n'a été trouvé" , 'msg2' => "Malheureusement ! En ce moment Vous n'êtes encadreur d'aucun sujet " ])
@else
<div class="row">



        
            
            
            <!-- END TIMELINE FILTER -->
           @foreach ($posts as $post)
                
                    <div class="panel panel-default" >
                        <div class="panel-body posts">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="post-item">
                                        <div class="post-title">
                                            <a href="/{{strtolower(Auth::user()->userable_type)}}/posts/{{$post->id}}">{{$post->Titre}}</a>
                                        </div>
                                        <div class="post-date"><span class="fa fa-calendar"></span>
                                        Soumis le :{{$post->created}} / par
                                       
                                        {{$post->userposter->username}}
                                        
                                        <br>
                                        @if ($post->updated_at != $post->created_at )
                                            Dernière Modification : {{$post->updated}}
                                        @endif
                                         
                                        </div>
                                        

                                        <div class="post-text">   
                                                    @if ( !empty($post->imagePath) )
                                                        
                                                        <img src="/{{$post->imagePath}}" 
                                                    class="img-text post-image img-responsive"/>

                                                    @endif
                                                    
                                                    <p>
                                                        {{$post->Resume}}

                                                    </p>
                                        </div>

                                        <div class="post-row">
                                        
                                            <a href="/{{strtolower(Auth::user()->userable_type)}}/posts/{{$post->id}}" class="btn btn-default btn-rounded pull-right">Voir détails &RightArrow;</a>

                                        </div>
                                    </div>                                            
                                    
                                </div>
                            </div>

                            
                        </div>
                    </div>

            @endforeach
            
</div>
@endif