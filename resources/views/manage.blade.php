{{ config(['app.name' => 'Управление поездками']) }}

@extends('layouts.app')

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.a_users').hide();
            $('.spoiler').click(function () {
                $(this).find('.glyphicon').toggleClass('glyphicon-plus').toggleClass('glyphicon-remove');
                $(this).parent().parent().next().slideToggle(1);

                if ($(this).find('.glyphicon').hasClass('glyphicon-plus')) $(this).find('.more-text').text(' More info');
                else $(this).find('.more-text').text(' Close info');
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="pull-left">My Rides</h1>
                <a href="{{ route('profile.rides.add') }}" class="btn btn-primary pull-right">New Ride</a>
                <table class="table table-rides text-center">
                    <thead>
                    <tr>
                        <th>Date of Ride</th>
                        <th>Date of Registration</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Price</th>
                        <th>Number of seats</th>
                        <th>Associated Users</th>
                        <th>Used Places</th>
                        <th>Value Received</th>
                        <th>More Information</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($my_rides as $my_ride)
                        <?php
                        $users_count = $my_ride->users->count();
                        ?>
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($my_ride->start_at)) }}</td>
                            <td>{{ $my_ride->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $my_ride->origin }}</td>
                            <td>{{ $my_ride->destination }}</td>
                            <td>{{ $my_ride->price }}</td>
                            <td>{{ $my_ride->seats }}</td>
                            <td>{{ $users_count }}</td>
                            <td>{{ ($users_count / $my_ride->seats) * 100 }}%</td>
                            <td>{{ $users_count * $my_ride->price }}</td>
                            <td><a class="btn btn-default spoiler" href="#"><span
                                            class="glyphicon glyphicon-plus"></span> <span
                                            class="more-text">More info</span></a></td>
                        </tr>
                        <tr class="a_users">
                            <td colspan="10">
                                <div class="associated-users">
                                    <h3>Associated Users</h3>
                                    <div class="row">
                                    @forelse($my_ride->users as $a_user)
                                        <!-- USER -->
                                            <div class="col-sm-2 col-lg-2 col-md-2">
                                                <div class="thumbnail">
                                                    <div class="clearfix heading text-center">
                                                        <img class="img-circle" style="width: 40px; height: 40px;"
                                                             src="{{ asset('img/avatars/'.$a_user->avatar) }}" alt="Avatar"/>
                                                    </div>

                                                    <div class="thumbnail-footer">
                                                        <small class="text-center help-block">{{ $a_user->name }}</small>
                                                        <small class="text-center help-block">{{ $a_user->email }}</small>
                                                        <small class="text-center help-block">{{ getAge($a_user->birthdate) }} years old</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END USER -->
                                        @empty
                                            <h4>Пользователей нет</h4>
                                        @endforelse
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <hr/>

                <h1>My Associated Rides</h1>
                <div class="row">
                @forelse($associate_rides as $ride)
                    <!-- RIDE -->
                        <div class="col-sm-3 col-lg-3 col-md-3 rides__item" style="animation-delay: {{ $loop->index / 2 }}s" data-id="{{ $ride->ride_id }}">
                            <div class="thumbnail">
                                <div class="clearfix heading">
                                    <img class="img-circle pull-left" style="width: 85px; height: 85px;" src="{{ asset('img/avatars/'.$ride->ride->owner->avatar) }}"
                                         alt="Avatar">
                                    <strong class="date">{{ date('d/m/Y', strtotime($ride->ride->start_at)) }}</strong>
                                </div>

                                <div class="caption">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="h6">Origin</h4>
                                            <strong class="text-uppercase">{{ $ride->ride->origin }}</strong>
                                        </div>

                                        <div class="pull-right text-right">
                                            <h4 class="h6">Destination</h4>
                                            <strong class="text-uppercase">{{ $ride->ride->destination }}</strong>
                                        </div>
                                    </div>

                                    <div class="clearfix">
                                        <div class="pull-right text-right">
                                            <h4 class="h6">U$ PRICE</h4>
                                            <strong class="text-uppercase">{{ (int)$ride->ride->price === 0 ? 'FREE' : number_format($ride->ride->price, '2', ',', '.') }}</strong>
                                        </div>
                                        <div class="pull-left">
                                            <h4 class="h6">Seats available</h4>
                                            <strong class="text-uppercase">{{ $ride->ride->seats - $ride->ride->users->count() }}</strong>
                                        </div>
                                    </div>

                                    <a href="#" class="btn btn-danger btn-block btn-join text-uppercase" onclick="new CustomConfirm('Вы хотите отсоединиться от поездки?', function() {unjoin({{ $ride->ride_id }})})">Delete</a>
                                </div>

                                <div class="thumbnail-footer">
                                    <small class="text-center help-block">Associated in {{ date('d/m/Y H:i', strtotime($ride->created_at)) }}</small>
                                    <small class="text-center help-block">Owner: {{ $ride->ride->owner->name }}</small>
                                    <small class="text-center help-block">E-mail: {{ $ride->ride->owner->email }}</small>
                                </div>
                            </div>
                        </div>
                        <!-- END RIDE -->
                    @empty
                        <h3>Вы ещё не присоединялись к поездкам!</h3>
                    @endforelse

                    <div class="col-md-12 text-center">
                        {{ $associate_rides->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection