<div wire.poll>
<div class="bg-gray-100 dark:bg-gray-900">

    @if($premium == false)
    
<div class='column is-fullwidth pb-4'>
    <h1 class="is-size-2 light-text">SPOTiFY PREMiUM REQUiRED</h1>
</div>
    @endif
    <div id="#top" class='column is-fullwidth pb-4'>

         <div class="field has-addons">
          <p class="control">
              <span class="select">
                  <select>
                    <option value="Gifs">Tracks</option>
                    <option value="Stickers">Artists</option>
                  </select>
              </span>
          </p>
          <p class="control is-expanded">
              <input class="input is-primary is-primary-focus is-fullwidth" wire:keydown.enter="searchSpotify" wire:model="search" type="search" placeholder="Search for a track.. Whats on your mind?">
          </p>
          <p class="control">
              <button class="button h-button is-primary is-elevated" wire:click="searchSpotify()" wire:loading.attr="disabled" wire:loading.class="button is-primary is-loading"  wire:target="search">Search</button>
          </p>
      </div>
  </div>

  @isset($results)
  <div class="column mt-4 pb-4">
        <div class="buttons is-centered">
          <button 
          class="button is-warning is-elevated" 
          wire:click="clearInput" 
          wire:loading.attr="disabled" 
          wire:loading.class="is-loading" 
          
          >
              <span class="icon">
                  <i data-feather="trash"></i>
              </span>
              <span>Clear</span>
          </button>
          
          <button class="button h-button is-primary is-outlined" onclick="scrollToResults()">
              <span class="icon">
                  <i data-feather="arrow-down"></i>
              </span>
              <span>Scroll To Results</span>
          </button>
       
      </div>
  </div>
@endisset

<div class="columns is-vcentered">                   
<div class="column is-one-third">
<div class="r-card is-raised">
     <div class="demo-title">
        @isset ($host)
        <h4 class="title is-4 is-narrow is-bold">{{ $host->name }}'s Sound Party <i class="fa-thin fa-face-party" style="color: #ad7fa8;"></i> </h4>
        @endisset
        </div>
        <div class="is-divider"></div>
        @isset($host)
        <p class="light-text">Host: {{ $host->name }}</p>
        <p class="light-text">Members: {{ $members }}</p>
        <p class="light-text">Session: {{ $member[0] ?? 'null' }}</p>
        @php
         /* 
        <p class="light-text">Test Service: {{ $re ?? 'null' }}</p>
        */
        @endphp

        @endisset

       
        
        <p class="is-size-5 title is-4 is-narrow is-bold p-4">Invite others to the party!</p>
        <input type="text" value="{{ $url }}" id="copyURL" hidden>
        <button id="copybutton" onclick="copyURL()" class="button h-button is-primary is-raised is-fullwidth">
            <span class="icon">
              <i data-feather="copy"></i>
          </span>
          <span>Copy Party Link</span>
        </button>

        <div class="is-divider"></div>
        @auth
        <div class="buttons is-centered">
        <button wire:click="prevSong()" class="button is-danger is-raised is-halfwidth" wire:loading.class="is-loading is-primary">
             <span class="icon">
              <i data-feather="skip-back"></i>
          </span>
            <span>Previous Song</span>
        </button>
        
        <button wire:click="nextSong()" class="button is-success is-raised is-halfwidth" wire:loading.class="is-loading is-primary">
             <span class="icon">
              <i data-feather="skip-forward"></i>
          </span>
            <span>Next Song</span>
       </button>
        </div>
        
        @endauth
        

       
        @if ($isRegistered == false && Auth::guest())
        <button wire:click="joinParty()" class="button is-danger is-rounded">Join Party</button>
        @endif
        
        
    </div>
          
    </div>
    <div class="column is-one-third mt-0">
        @if ($premium == false)
        <div class="l-card h-card is-raised" style="height:30vh;">
        @else
        <div class="l-card h-card is-raised" style="height:65vh;">
        @endif
        <h4 class="title is-4 is-narrow is-bold pb-4">The Queue</h4>
        @if (empty($queue))
        <h3 class="title is-6">{{ $host->name ?? 'Host,' }}, Press Play on Spotify to Begin</h3>
        @endif
         @php
         /*   
         Voted to skip! (animation) - {{ $queue[$skiptrack[0]] }}
         */
         @endphp

                            <div class="select is-large is-fullwidth has-text-center" wire.model.live="viewQueue">
                            
                            @if ($premium == false)
                            <select multiple size="3" class="has-slimscroll has-text-centered" wire:model.live="skiptrack">
                            @else
                            <select 
                            multiple size="14" 
                            class="has-slimscroll has-text-centered" 
                            wire:model.live="skiptrack"
                            >
                            @endif
                        
                            @isset($queue)
                            @foreach ($queue as $k => $v)
                            @php
                            $first = array_key_first($queue);
                            @endphp
                            @if($first == $k)
                            <option value="{{ $k }}" class="is-size-6">Now Playing: {{ $v }}</option>
                            @else
                            <option value="{{ $k }}" class="is-size-6">{{ $v }}</option>
                            @endif
                            @endforeach
                            @else
                            <option class="is-size-4">SPOTiFY PREMiUM REQUiRED</option>
                            @endisset

                            </select>
                     
                            
                            
                            <button 
                            wire:click="voteToSkip('true')" 
                            class="button is-warning is-fullwidth is-size-5"
                            wire:loading.class.remove="is-warning"
                            wire:loading.class="is-success is-loading"
                            >Vote to Skip</button>
                            </div>
                               
                        
            
          
        </div>
                                                 

</div>
<div class="column is-one-third">

        <div class="s-card h-card is-raised" style="height:40vh;">
            
        <h4 class="title is-4 is-narrow is-bold pb-4">Songs that risk being skipped (majority vote)</h4>
        @isset($skips)
                            <div class="select is-large is-fullwidth has-text-center pb-4">
                            <select 
                            multiple size="5" 
                            class="has-text-centered has-slimscroll" 
                            wire:target="voteToSkip('true')">
                            
                            
                            @foreach ($skips as $k => $v)
                            @if(!(empty($queue[$k])))
                            <option value="{{ $k }}" class="is-size-6">{{ $queue[$k] }} ({{ $v }})</option>
                            @endif
                            @endforeach
                           

                            </select>
                           
                            </div>
            @endisset
                </div>

</div>
</div>

@isset($results)
 <div class="column is-fullwidth mt-4 pb-4">
        <div class="buttons is-centered">
          <button class="button h-button is-info is-outlined is-halfwidth" onclick="scrollToTop()">
              <span class="icon">
                  <i data-feather="eye"></i>
              </span>
              <span>Search?</span>
          </button>
          <button class="button h-button is-primary is-outlined is-halfwidth" onclick="scrollToBottom()">
              <span class="icon">
                  <i data-feather="edit-2"></i>
              </span>
              <span>Scroll To Bottom</span>
          </button>
      </div>
  </div>

<div class="columns is-multiline is-vcentered bg-gray-100 dark:bg-gray-900">

        @foreach ($results as $k => $result)
            @if($loop->first)
             <div id="#searchResults" wire:key="results-{{$k}}" id="#{{ $tracksids[$k] }}" class="column is-4 p-4 has-text-centered">
            @elseif($loop->iteration % 4 == 1)
                <div wire:key="results-{{$k}}" id="#{{ $tracksids[$k] }}" class="column is-4 p-4 has-text-centered">
            @endif
            <!-- Display the image here -->
            <img style="border-radius: unset; height: unset; width: unset; padding-bottom:1rem;" src="{{ $result[1]['url'] }}" alt="" loading="lazy" height="50%"/>
            <h1 class="title is-thin is-5"> {{ $artists[$k][0]['name'] }}</h1>

            <h1 class="title is-bold is-6"> {{ $albums[$k]['name'] }} - {{ $albums[$k]['release_date'] }}</h1>
            <h1 class="title is-bold is-6 inverted-text"> {{ $tracks[$k] }}</h1>
           
            
            <button
            wire:key="addToQueue-{{$k}}"
            wire:target="addToQueue('{{ $tracksids[$k] }}')"
            wire:click="addToQueue('{{ $tracksids[$k] }}')"
            
            class="button is-primary is-rounded"
            wire:loading.class.remove="is-primary"
            wire:loading.class="is-success is-loading"
            >Add to Queue</button>
            
            <br>
            <br>

            @if($loop->iteration % 4 == 0 || $loop->last)
                </div>
            @endif
        @endforeach


    
        </div>


        <div id="#thebottom" class="columns is-multiline is-fullwidth">
        
         <div class="column buttons is-centered pb-4">
          <button class="button is-fullwidth is-primary is-rounded is-raised" onclick="scrollToTopResults()">
              <span class="icon">
                  <i data-feather="eye"></i>
              </span>
              <span>Scroll up</span>
          </button>
      </div>

        <div class="column" id="#thebottom">
         <button wire:loading.class="is-warning is-loading"  wire:click="loadMore()" class="button is-fullwidth is-success is-rounded">Load More</button>
        </div>
        
           <div class="column buttons is-centered pb-4">
          <button class="button is-fullwidth is-primary is-rounded is-raised" onclick="scrollToTop()">
              <span class="icon">
                  <i data-feather="edit-2"></i>
              </span>
              <span>Search?</span>
          </button>
      </div>

        </div>
        @endisset
</div>
</div>

 <script type="text/javascript">
   

        function scrollToResults() {

            document.getElementById("#searchResults").scrollIntoView({
            behavior: 'smooth'
            });

        }

        function scrollToTop() {

            document.getElementById("#top").scrollIntoView({
            behavior: 'smooth'
            });

        }

        function scrollToBottom() {

            document.getElementById("#thebottom").scrollIntoView({
            behavior: 'smooth'
            });

        }

    function copyURL() {         
  // Get the text field
  var copyText = document.getElementById("copyURL");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  var tooltip = document.getElementById("copybutton");
        tooltip.innerHTML = "Url copied";  
    } 



       
    </script>

 