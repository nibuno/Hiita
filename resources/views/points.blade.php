@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2">
            <div class="card card-default">
                <div class="card-header">
                    的中の追加
                </div>

                <div class="card-body">
                    <!-- バリデーションエラーの表示 -->
                    @include('common.errors')

                    <!-- 的中登録フォーム -->
                    <form action="{{ url('point')}}" method="POST" class="form-horizontal">
                        @csrf

                        <!-- 的中の記録 -->
                        <div class="form-check">
                            <label for="points" class="control-label">的中記録</label>

                            <div class="col-sm-12">
                                <label class="checkbox-inline">
                                    <input type="hidden" name="one" value="0">
                                    <input type="checkbox" name="one" value="1">1射目
                                </label>
                                <label class="checkbox-inline">
                                    <input type="hidden" name="two" value="0">
                                    <input type="checkbox" name="two" value="1">2射目
                                </label>
                                <label class="checkbox-inline">
                                    <input type="hidden" name="three" value="0">
                                    <input type="checkbox" name="three" value="1">3射目
                                </label>
                                <label class="checkbox-inline">
                                    <input type="hidden" name="four" value="0">
                                    <input type="checkbox" name="four" value="1">4射目
                                </label>
                            </div>
                        </div>

                        <!-- メモ -->
                        <div class="group">
                            <label for="point-memo" class="col-sm-3 control-label">メモ</label>

                            <div class="col-sm-6">
                                <input type="text" id="memo" name="memo" class="form-control" value="{{ old('memo') }}">
                            </div>
                        </div>

                        <!-- 的中記録送信ボタン -->
                        <label for="points" class="control-label"></label>
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-plus"></i> 的中を記録する
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 現在の的中の表示 -->
            @if (count($points) > 0)
                <div class="card card-default">
                    <div class="card-header text-center">
                        今日の的中記録: {{ $todayShootsNumbers }}射 {{ $todayTotalPoints }}中 {{ $hitPointsPercentage }}%
                    </div>
                        
                    <div class="card-body table-responsive-sm">
                        <div class="table-responsive-sm">
                            <table class="table table-striped table-sm text-center text-nowrap">
                                <!-- テーブルヘッダ -->
                                <thead>
                                    <tr>
                                        <th>1射目</th>
                                        <th>2射目</th>
                                        <th>3射目</th>
                                        <th>4射目</th>
                                        <th>メモ</th>
                                    </tr>
                                </thead>
                                <!-- テーブル本体 -->
                                <tbody>
                                    @foreach ($points as $point)
                                        <tr>
                                            <td class="table-text">
                                                @if ( $point->one === 1 )
                                                    <div>◯</div>
                                                @else 
                                                    <div>×</div>
                                                @endif
                                            </td>
                                            <td class="table-text">
                                                @if ( $point->two === 1 )
                                                    <div>◯</div>
                                                @else 
                                                    <div>×</div>
                                                @endif
                                            </td>
                                            <td class="table-text">
                                                @if ( $point->three === 1 )
                                                    <div>◯</div>
                                                @else 
                                                    <div>×</div>
                                                @endif
                                            </td>
                                            <td class="table-text">
                                                @if ( $point->four === 1 )
                                                    <div>◯</div>
                                                @else 
                                                    <div>×</div>
                                                @endif
                                            </td>
                                            <td class="table-text">
                                                <div>{{ $point->memo }}</div>
                                            </td>
                                            <!-- TODO: 削除ボタン -->
                                            <td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection