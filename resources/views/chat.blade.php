<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Corporate Praise Generator</title>
      <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100">
    <div class="container mx-auto p-4">
      <h1 class="text-3xl font-bold text-center mb-6">Corporate Praise Generator</h1>

      <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div id="chat-messages" class="h-96 overflow-y-auto mb-4 p-2 border rounded">
          @if (isset($messages))
            @foreach($messages as $message)
              <div class="mb-3 {{ $message->sender == 'user' ? 'text-right' : '' }}">
                <div class="inline-block max-w-xs md:max-w-md lg:max-w-lg rounded-lg p-3 
                  {{ $message->sender == 'user' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                  {{ $message->content }}
                </div>
              </div>
            @endforeach
          @endif
        </div>

        <form id="chat-form" class="space-y-3">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <input type="text" name="boss_name" placeholder="Boss Name" required class="border rounded p-2" value="">
            
            <input type="text" name="company_name" placeholder="Company Name" required class="border rounded p-2" value="">
            
            <select name="boss_gender" required class="border rounded p-2">
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="flex space-x-2">
            <input type="text" name="message" placeholder="Your message or request..." required class="flex-grow border rounded p-2">
            <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">
              Send
            </button>
          </div>
        </form>
      </div>

      {{-- @if(!Auth::check())
        <div class="text-center">
          <p class="mb-2">Sign up for more sessions and responses!</p>
          <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
        </div>
      @endif --}}
    </div>
    {{-- // const response = await fetch('{{ route("chat.send") }}', { --}}
    <script>
      document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault()

        const formData = new FormData(this)
        const response = await fetch('{{ route("chat") }}', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        })

        const data = await response.json()

        if (data.error) {
          alert(data.error)
        } else {
          console.log(data)
          return;
          const userMsg = document.createElement('div')
          userMsg.className = 'mb-3 text-right'
          userMsg.innerHTML = `<div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-blue-500 text-white rounded-lg p-3">${formData.get('message')}</div>`

          const aiMsg = document.createElement('div')
          aiMsg.className = 'mb-3'
          aiMsg.innerHTML = `<div class="inline-block max-w-xs md:max-w-md lg:max-w-lg bg-gray-200 text-gray-800 rounded-lg p-3">${data.response}</div>`

          document.getElementById('chat-messages').appendChild(userMsg)
          document.getElementById('chat-messages').appendChild(aiMsg)

          // Scroll to bottom
          document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight

          // Clear message input
          this.querySelector('input[name="message"]').value = ''
        }
      });
    </script>
  </body>
</html>