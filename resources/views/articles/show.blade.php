@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- Back Button --}}
            <div class="d-flex justify-content-between mb-4">
                <a href="{{ route('admin.articles.index') }}" class="btn px-4 py-2"
                   style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>

            <!-- Article Details -->
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h1 class="fw-bold mb-3">{{ $article->title }}</h1>
                    <div class="mb-2 text-muted">
                        <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('d M Y') }}
                    </div>
                    <p class="lead" style="color: #5F738C;">{{ $article->description }}</p>
                    @if($article->thumbnail)
                        <div class="text-center my-4">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-fluid rounded" style="max-width: 100%;">
                        </div>
                    @endif

                    @if($article->subheadings->count())
                        @foreach($article->subheadings as $subheading)
                            <div class="mb-4">
                                <h3 class="fw-bold">{{ $subheading->title }}</h3>
                                @foreach($subheading->paragraphs as $paragraph)
                                    <p style="color: #5F738C;">{{ $paragraph->content }}</p>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Comments Section for Admin -->
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold fs-5 mb-4">Komentar ({{ $article->comments->count() }})</h3>

                    <!-- Comments List -->
                    <div class="comments-list">
                        @forelse($article->comments()->with('user')->latest()->get() as $comment)
                            <div class="comment-item border-bottom py-3">
                                <div class="d-flex align-items-start">
                                    <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                                         style="width: 40px; height: 40px; background-color: #F0F5FF;">
                                        <i class="fas fa-user" style="color: #5B93FF;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-medium">{{ $comment->user->name }}</h6>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-2" style="color: #5F738C;">{{ $comment->content }}</p>

                                        <!-- Admin delete comment -->
                                        <form action="{{ route('comments.destroy', $comment->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Belum ada komentar.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
