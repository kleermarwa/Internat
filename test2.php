<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <title>Document</title>
  <style>
    .edit-room-button {
      position: relative;
      transition: all 0.3s ease-in-out;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
      padding-block: 0.5rem;
      padding-inline: 1.25rem;
      background-color: rgb(0 107 179);
      border-radius: 9999px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffff;
      gap: 10px;
      font-weight: bold;
      border: 3px solid #ffffff4d;
      outline: none;
      overflow: hidden;
      font-size: 15px;
    }

    .icon {
      transition: all 0.3s ease-in-out;
    }

    .edit-room-button:hover {
      transform: scale(1.05);
      border-color: #fff9;
    }

    .edit-room-button:hover .icon {
      transform: translate(4px);
    }

    .edit-room-button:hover::before {
      animation: shine 1.5s ease-out infinite;
    }

    .edit-room-button::before {
      content: "";
      position: absolute;
      width: 100px;
      height: 100%;
      background-image: linear-gradient(120deg,
          rgba(255, 255, 255, 0) 30%,
          rgba(255, 255, 255, 0.8),
          rgba(255, 255, 255, 0) 70%);
      top: 0;
      left: -100px;
      opacity: 0.6;
    }

    @keyframes shine {
      0% {
        left: -100px;
      }

      60% {
        left: 100%;
      }

      to {
        left: 100%;
      }
    }
  </style>
</head>

<body>
  <button class="button">
    Apply Now
    <i class="fa fa-plus icon"></i>
  </button>
</body>

</html>