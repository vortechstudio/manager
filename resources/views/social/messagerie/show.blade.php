@extends("layouts.app")
@section("title")
    Message: {{ $message->message_subject }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$message->message_subject"
        :breads="array('Social', 'Service de messagerie', $message->message_subject)" />

    <div class="card shadow-sm">
        <div class="card-header">
           <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0" role="tablist">
               <li class="nav-item px-3">
                   <a href="#content" class="nav-link active" data-bs-toggle="tab">Contenue</a>
               </li>
               <li class="nav-item px-3">
                   <a href="#rewards" class="nav-link" data-bs-toggle="tab">Récompenses</a>
               </li>
           </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="content" role="tabpanel">
                    <livewire:social.messagerie.content-panel :message="$message" />
                </div>
            </div>
        </div>
    </div>

@endsection
