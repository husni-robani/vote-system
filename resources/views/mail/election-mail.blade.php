<x-mail::message>
    Hi

    It's time to make your voice heard in the HIMATIF election!

    Your unique voting link is ready:

    @component('mail::button', ['url' => $link])
        Vote
    @endcomponent
{{--    <x-mail::button :url="$link">--}}
{{--    Button Text--}}
{{--    </x-mail::button>--}}

    Click the button above, cast your vote, and be part of shaping our future. 🚀

    If you run into any hiccups or have questions, reach out to us at hima.teknikinformatika@widyatama.ac.id We're here to help.

    Your vote counts, so don't miss this chance to have your say.

    Thanks for being an active member of our community!

    Best,<br>
    Himpunan Mahasiswa Teknik Informatika
    Universitas Widyatama
</x-mail::message>
