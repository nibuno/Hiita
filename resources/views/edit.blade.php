@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2">
            <div class="card card-default">
                <div class="card-body">
                    <!-- バリデーションエラーの表示 -->
                    @include('common.errors')

                    <!-- 的中編集フォーム -->
                    <form action="{{ url('update/' . $point->id) }}" method="POST" class="form-horizontal">
                        @csrf

                        <!-- 的中の記録 -->
                        <div class="form-check">
                            <div class="col-sm-6">
                                @foreach ($points as $point)
                                    <label class="checkbox-inline">
                                        <input type="hidden" name="one" value="0">
                                        
                                        <input type="checkbox" name="one" value="1"
                                            @if ($point->one === 1)
                                            checked
                                            @endif
                                        >1射目
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="hidden" name="two" value="0">
                                        <input type="checkbox" name="two" value="1"
                                            @if ($point->two === 1)
                                            checked
                                            @endif
                                        >2射目
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="hidden" name="three" value="0">
                                        <input type="checkbox" name="three" value="1"
                                            @if ($point->three === 1)
                                            checked
                                            @endif
                                        >3射目
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="hidden" name="four" value="0">
                                        <input type="checkbox" name="four" value="1"
                                            @if ($point->four === 1)
                                            checked
                                            @endif
                                        >4射目
                                @endforeach
                            </div>
                        </div>

                        <!-- メモ -->
                        <div class="group">
                            <div class="col-sm-6">
                                @foreach ($points as $point)
                                    <input type="text" id="memo" name="memo" class="form-control" 
                                    value="{{ $point->memo }}">
                                @endforeach
                            </div>
                        </div>

                        <!-- 的中記録送信ボタン -->
                        <label for="points" class="control-label"></label>
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-plus"></i> 更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection