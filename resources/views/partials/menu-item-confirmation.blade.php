<li class='nav-item'>
    <a class='nav-link'
       href='{{ $url ?? "#" }}'
       data-prompt='{{ $prompt ?? false }}'
       onclick="urlConfirm(event)"
       title="{{ $confirmation ?? "Are you sure you want to run this command?" }}">
        <i class='nav-icon {{ $icon ?? "la la-question" }}'></i> {{ $text ?? "Unknown" }}
    </a>
</li>
