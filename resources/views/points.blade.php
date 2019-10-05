@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    的中の追加
                </div>

                <div class="panel-body">
                    <!-- バリデーションエラーの表示 -->
                    @include('common.errors')

                    <!-- 的中登録フォーム -->
                    <form action="{{ url('point')}}" method="POST" class="form-horizontal">
                        @csrf

                        <!-- 的中名 -->
                        <div class="form-group">

                            <label for="points" class="col-sm-3 control-label">的中記録</label>

                            <div class="col-sm-6">
                                <label class="checkbox-inline"><input type="checkbox" value="one">1射目</label>
                                <label class="checkbox-inline"><input type="checkbox" value="two">2射目</label>
                                <label class="checkbox-inline"><input type="checkbox" value="three">3射目</label>
                                <label class="checkbox-inline"><input type="checkbox" value="four">4射目</label>
                            </div>

                            <label for="point-memo" class="col-sm-3 control-label">メモ</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="memo" class="form-control" value="{{ old('memo') }}">
                            </div>
                        </div>

                        <!-- 的中記録ボタン -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i> 的中を記録する
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TODO: 現在の的中の表示 -->
        </div>
    </div>
@endsection