@extends('layouts.master')

@section('content')

<div class="container px-4 px-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <!-- Back Button -->
            <div class="d-flex justify-content-between mb-4 mt-4">
                <a href="{{ route('front.index') }}" class="btn px-4 py-2"
                style="background-color: #F0F5FF; color: #5B93FF; border-radius: 8px;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>


            <!-- Article Header -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge rounded-pill px-3 py-2"
                          style="background-color: {{ $article->status == 'Published' ? '#E6F7F1' : '#f5f5f5' }};
                                color: {{ $article->status == 'Published' ? '#36b37e' : '#6c757d' }};">
                        {{ $article->status }}
                    </span>
                    <div class="text-muted small">
                        <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('d M Y') }}
                    </div>
                </div>

                <h1 class="fw-bold mb-3 article-text">{{ $article->title }}</h1>

                <div class="d-flex align-items-center mb-4">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-3"
                         style="width: 40px; height: 40px; background-color: #F0F5FF;">
                        <i class="fas fa-user" style="color: #5B93FF;"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">{{ $article->author }}</p>
                        <p class="text-muted small mb-0">Author</p>
                    </div>
                </div>

                @if($article->thumbnail)
                    <div class="text-center my-4">
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail"
                             class="img-fluid mx-auto d-block"
                             style="max-width: 100%; height: auto; border-radius: 16px;">
                    </div>
                @endif
            </div>


            <!-- Article Content -->
            <div class="mb-4">
                <!-- Description Section -->
                <div class="article-description mb-4">
                    <div class="p-3 rounded-3" style="background-color: #F8FAFD;">
                        <p class="lead mb-0" style="color: #5F738C;">{{ $article->description }}</p>
                    </div>
                </div>

                <!-- Main Content -->
                @if($article->subheadings->count())
                    <div class="article-content">
                        @foreach($article->subheadings as $subheading)
                            <div class="subheading-section mb-4">
                                <h3 class="fw-bold mb-3 article-text" style="color: #3A4A5C; padding-bottom: 10px; border-bottom: 2px solid #F0F5FF;">
                                    {{ $subheading->title }}
                                </h3>
                                @foreach($subheading->paragraphs as $paragraph)
                                    <div class="paragraph mb-4">
                                        <p style="line-height: 1.8; color: #5F738C;">{{ $paragraph->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Comments Section -->
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold fs-5 mb-4 article-text">Komentar ({{ $article->comments->count() }})</h3>

                    <!-- Comment Form -->
                    @auth
                        <form action="{{ route('comments.store', $article->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" rows="3" class="form-control @error('content') is-invalid @enderror"
                                    placeholder="Tulis komentar Anda..."></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Komentar
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2 article-text"></i>
                            Silakan <a href="{{ route('login') }}">login</a> untuk memberikan komentar.
                        </div>
                    @endauth

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

                                        @auth
                                            @if(auth()->id() === $comment->user_id)
                                                <div class="comment-actions">
                                                    <button class="btn btn-sm btn-link text-primary edit-comment"
                                                            data-comment-id="{{ $comment->id }}"
                                                            data-content="{{ $comment->content }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
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
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0 article-text">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .article-content h3 {
        font-size: 1.5rem;
    }

    .article-content p {
        font-size: 1.05rem;
    }

    .lead {
        font-size: 1.15rem;
        font-weight: 400;
    }
    .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(108, 99, 255, 0.3);
}
 .comment-item:last-child {
        border-bottom: none !important;
    }

    .comment-actions {
        font-size: 0.875rem;
    }

    .comment-actions .btn-link {
        padding: 0.25rem 0.5rem;
        text-decoration: none;
    }

    .comment-actions .btn-link:hover {
        text-decoration: underline;
    }


    @media (max-width: 768px) {
        .article-content h3 {
            font-size: 1.3rem;
        }

        img.img-fluid {
            max-width: 100% !important;
        }
    }
</style>

@push('scripts')
<script>
    // Edit comment functionality
    document.querySelectorAll('.edit-comment').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const content = this.dataset.content;

            // Create edit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/comments/${commentId}`;
            form.innerHTML = `
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea name="content" rows="3" class="form-control">${content}</textarea>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm cancel-edit">Batal</button>
                </div>
            `;

            // Replace comment content with form
            const commentContent = this.closest('.comment-item').querySelector('p');
            commentContent.replaceWith(form);

            // Handle cancel
            form.querySelector('.cancel-edit').addEventListener('click', () => {
                form.replaceWith(commentContent);
            });
        });
    });
</script>
@endpush
@endsection
