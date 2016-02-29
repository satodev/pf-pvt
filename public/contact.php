<h1>Contact</h1>
<?php
$message = new Message();
?>
<div class="row small-12 large-10 medium-6 columns">
<form action="../partials/form_receiver.php" method="POST">
   <label>Nom/Prénom :
          <input type="text" name="name" placeholder="Nom" aria-describedby="nameExample">
        </label>
        <p class="help-text" id="nameExample">Martin Dubois</p>
        <label>Email :
          <input type="email" name="email" placeholder="Email" aria-describedby="emailExample">
        </label>
        <p class="help-text" id="emailExample">example@mailbox.com</p>
        <label>Sujet :
          <input type="text" name="sujet" placeholder="Sujet" aria-describedby="subjectExample">
        </label>
        <p class="help-text" id="subjectExample">[PHOTOGRAPHE] Recherche modèle</p>
        <label>Message :
          <textarea type="text" name="message" placeholder="Message"></textarea>
        </label>
            <input class="button" type="submit">
      </form>
      </div>
      <?php
      if($_GET['send']){
        if($_GET['send'] == 'true'){
          echo '<div class="callout success">Message envoyé</div>';
         }else{
          echo '<div class="callout alert ">Erreur Lors de l\'envoi du message : '.$message->getState().'</div>';
        }
      }