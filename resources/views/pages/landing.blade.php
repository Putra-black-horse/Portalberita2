@extends('layouts.app')

@section('title', 'Moco | Baca Berita')

@section('content')
 <!-- swiper -->
    <div class="swiper mySwiper mt-9">
      <div class="swiper-wrapper">
          @foreach ($banners as $banner)
    <div class="swiper-slide">
        <a href="{{ route('news.show', $banner->news->slug) }}" class="block">
            <div
                class="relative flex flex-col gap-1 justify-end p-3 h-72 rounded-xl bg-cover bg-center overflow-hidden"
                   style="background-image: url('{{ asset('storage/'.$banner->news->thumbnail) }}')">
                
                <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[rgba(0,0,0,0.4)] to-[rgba(0,0,0,0)] rounded-b-xl"></div>
                
                <div class="relative z-10 mb-3" style="padding-left: 10px;">
                    <div class="bg-primary text-white text-xs rounded-lg w-fit px-3 py-1 font-normal mt-3">
                        {{ $banner->news->newsCategory->title    }}
                    </div>
                    
                    <p class="text-3xl font-semibold text-white mt-1">
                        {{ $banner->news->title}}
                    </p>

                    <div class="flex items-center gap-1 mt-1">
                        <img src="{{ asset('storage/'.$banner->news->author->avatar)}}" alt=""
                            class="w-5 h-5 rounded-full">
                        <p class="text-white text-xs">
                            {{ $banner->news->author->name  }}
                        </p>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
 @if(session('message'))
  <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded mt-4">
    {{ session('message') }}
  </div>
@endif
      </div>
    </div>
   

    <!-- Berita Unggulan -->
    <div class="flex flex-col px-14 mt-10 ">
      <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
        <div class="font-bold text-2xl text-center md:text-left">
          <p>Berita Unggulan</p>
          <p>Untuk Kamu</p>
        </div>
      </div>
     <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
      
        @foreach ($featureds as $featured ) 
        <a href="{{ route('news.show',$featured->slug) }}">
          <div
            class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out"
            style="height: 100%;  " >
            <div
            class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">
                {{ $featured->newsCategory->title }}

            </div>
            <img src="{{ asset('storage/' . $featured->thumbnail) }}" alt="" 
            class="w-full rounded-xl mb-3" style=" height: 150px; object-fit: cover;">
            <p class="font-bold text-base mb-1">{{ $featured->title }} </p>
            <p class="text-slate-400">{{ Carbon\Carbon::parse($featured->created_at)->format('d F Y') }}</p>
          </div>
        </a>
        @endforeach
          </div>

    </div>



<!-- Berita Terbaru -->
<div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10">
  <div class="flex flex-col md:flex-row w-full mb-6">
    <div class="font-bold text-2xl text-center md:text-left">
      <p>Berita Terbaru</p>
    </div>
  </div>

  <!-- Daftar Berita Horizontal dengan Thumbnail Seragam -->
  <div class="flex overflow-x-auto gap-5 pb-5 lg:grid lg:grid-cols-3 lg:gap-6 lg:overflow-visible">
    @foreach ($news as $new)
      <a href="{{ route('news.show', $new->slug) }}"
         class="flex-shrink-0 flex flex-col w-80 lg:w-full bg-white border border-slate-200 p-3 rounded-xl hover:border-primary hover:shadow-md transition-all duration-300 h-96">
        
        <!-- Kategori (Badge) -->
        <div class="bg-primary text-white rounded-full px-4 py-1 font-normal text-sm absolute ml-2 mt-2 z-10">
          {{ $new->newsCategory->title }}
        </div>

        <!-- Thumbnail dengan Ukuran Tetap -->
        <div class="w-full h-48 overflow-hidden rounded-xl mt-3">
          <img src="{{ asset('storage/' . $new->thumbnail) }}" 
               alt="{{ $new->title }}" 
               class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
        </div>

        <!-- Konten Teks -->
        <div class="mt-4 pt-2 flex flex-col flex-grow px-1">
          <p class="font-semibold text-lg line-clamp-2 leading-tight">{{ $new->title }}</p>
          <p class="text-slate-500 text-sm mt-2 line-clamp-3">
            {!! \Str::limit(strip_tags($new->content), 120) !!}
          </p>
          <p class="text-slate-400 text-xs mt-auto">
            {{ Carbon\Carbon::parse($new->created_at)->format('d F Y') }}
          </p>
        </div>
      </a>
    @endforeach
  </div>
</div>



    <!-- Author -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10">
      <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
        <div class="font-bold text-2xl text-center md:text-left">
          <p>Kenali Author</p>
          <p>Terbaik Dari Kami</p>
        </div>
      </div>
      <div class="grid grid-cols-1  sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <!-- Author 1 -->
        @foreach ($authors as $author)
         <a href="{{ route('author.show', $author->username)  }}">
          <div
             class="flex flex-col items-center border border-slate-200 px-4 py-8 rounded-2xl hover:border-primary hover:cursor-pointer">
             <img src="{{ asset('storage/'. $author->avatar) }}" alt="" class="rounded-full w-24 h-24">
             <p class="font-bold text-xl mt-4">{{ $author->name }}</p>
             <p class="text-slate-400">{{ $author->news->count() }} Berita</p>
          </div>
        </a>
        @endforeach  
      </div>
    </div>

    <!-- Pilihan Author -->
    <div class="flex flex-col px-14 mt-10 mb-10">
      <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
        <div class="font-bold text-2xl text-center md:text-left">
          <p>Pilihan Author</p>
        </div>
      </div>
      <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
        @foreach ($news as $choice )
         <a href="{{ route('news.show', $choice->slug) }}">
          <div
            class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out"
            style="height: 100%;">
            <div 
              class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">
              {{$choice->newsCategory->title }}
            </div>
            <img src="{{ asset('storage/'. $choice->thumbnail ) }}" alt="" 
                 class="w-full rounded-xl mb-3" style="height: 200px; object-fit: cover;">
            <p class="font-bold text-base mb-1">
                {{ $choice->title }}
            </p>
            <p class="text-slate-400">{{ \Carbon\Carbon::parse($choice->created_at)->format('d F Y') }}</p>
          </div>
        </a>
        @endforeach  
      </div>
    </div>

@endsection

