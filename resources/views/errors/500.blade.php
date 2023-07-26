@extends('errors::minimal')

@section('title', __('Oops! something went wrong'))
@section('code', '500')
@section('message', __('Something went wrong and this operation could not be performed, please try again'))
