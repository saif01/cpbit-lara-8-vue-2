@extends('errors::minimal')

@section('title', __('Error'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbiddenrrrr'))
