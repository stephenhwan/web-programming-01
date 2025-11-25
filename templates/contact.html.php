<section class="compose">
  <form class="compose-form" method="post" novalidate>
    <div class="row">
      <label for="to">To: </label>
      <input id="to" type="email" name="email" required placeholder="name@example.com">
    </div>

    <div class="row">
      <label for="subject">Subject: </label>
      <input id="subject" type="text" name="subject" required placeholder="Short subject…">
    </div>

    <div class="row body">
      <label for="message"></label>
      <textarea id="message" name="message" rows="10" required placeholder="Write your message…"></textarea>
    </div>

    <div class="actions">
      <button class="send" name="submit" type="submit">Send</button>
    </div>
  </form>
</section>