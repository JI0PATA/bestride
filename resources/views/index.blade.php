@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Available Rides</h1>
                <div class="row">

                @forelse($rides as $ride)
                    <!-- RIDE -->
                        <div class="col-sm-3 col-lg-3 col-md-3 rides__item"
                             style="animation-delay: {{ $loop->index / 2 }}s" data-id="{{ $ride->id }}">
                            <div class="thumbnail">
                                <div class="rides__more">
                                    {{ $ride->more }}
                                </div>
                                <div class="clearfix heading">
                                    <img class="img-circle pull-left"
                                         src="{{ asset('img/avatars/'.$ride->owner->avatar) }}" alt="Avatar"
                                         style="width: 85px; height: 85px;">
                                    <strong class="date">{{ date('d/m/Y', strtotime($ride->start_at)) }}</strong>
                                </div>

                                <div class="caption">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="h6">Origin</h4>
                                            <strong class="text-uppercase">{!! str_replace(mb_strtoupper(\Request::get('search')), '<span class="red">'.\Request::get('search').'</span>', mb_strtoupper($ride->origin)) !!}</strong>
                                        </div>

                                        <div class="pull-right text-right">
                                            <h4 class="h6">Destination</h4>
                                            <strong class="text-uppercase">{!! str_replace(mb_strtoupper(\Request::get('search')), '<span class="red">'.\Request::get('search').'</span>', mb_strtoupper($ride->destination)) !!}</strong>
                                        </div>
                                    </div>

                                    <div class="clearfix">
                                        <div class="pull-right text-right">
                                            <h4 class="h6">U$ PRICE</h4>
                                            <strong class="text-uppercase">{{ (int)$ride->price === 0 ? 'FREE' : number_format($ride->price, '2', ',', '.') }}</strong>
                                        </div>
                                        <div class="pull-left">
                                            <h4 class="h6">Seats available</h4>
                                            <strong class="text-uppercase">{{ $ride->seats - $ride->users->count() }}</strong>
                                        </div>
                                    </div>

                                    @auth
                                        <a href="#" class="btn btn-primary btn-block btn-join text-uppercase"
                                           onclick="new CustomConfirm('Вы хотите присоединиться?', function() {
                                                   join({{ $ride->id }})
                                                   })">Join</a>
                                    @endauth
                                </div>

                                <div class="thumbnail-footer">
                                    <small class="text-center help-block">
                                        Registered {{ $ride->created_at->format('d/m/Y H:i') }}</small>
                                    <small class="text-center help-block">by {{ $ride->owner->name }}</small>
                                </div>
                            </div>
                        </div>
                        <!-- END RIDE -->
                    @empty
                        <h3>Нет поездок</h3>
                    @endforelse

                    <div class="col-md-12 text-center">
                        {{ $rides->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
