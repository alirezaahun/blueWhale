@extends('layouts.master')
@section('content')
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>title</th>
                <th>image</th>
                <th>operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $blog)
                <tr>
                    <td>{{$blog->title}}</td>
                    <td><img src="{{url(env('Blog_Save_Path') . $blog->file->path)}}" style="height: 50xp;width:50px" alt="ss" srcset=""></td>
                    <td>
                        <a href="{{ route('admin.blogs.edit', ['blog' => $blog->id]) }}"
                            class="btn btn-outline-info">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        {{-- <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot> --}}
    </table>
@endsection
