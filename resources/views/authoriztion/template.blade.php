        
@can('update', $comment)

@endcan

@cannot('update', $comment)

@endcannot

@can('create', Comment::class)
    
@endcan

@cannot('create', Comment::class)
    
@endcannot
