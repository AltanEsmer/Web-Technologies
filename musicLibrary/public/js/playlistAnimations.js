// show.blade.php and index.blade.php animations section
document.addEventListener('DOMContentLoaded', () => {
  const playlistCards = document.querySelectorAll('.playlist-card');

  if (playlistCards) {
      playlistCards.forEach((card, index) => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          card.style.transition = `opacity 0.6s ease, transform 0.6s ease`;
          
          setTimeout(() => {
              card.style.opacity = '1';
              card.style.transform = 'translateY(0)';
          }, index * 200);
      });
  }
});

if (document.querySelectorAll('.playlist-card')) {
  document.querySelectorAll('.playlist-card').forEach((card) => {
      card.addEventListener('mouseover', () => {
          card.style.transform = 'scale(1.05)';
          card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
      });
      card.addEventListener('mouseout', () => {
          card.style.transform = 'scale(1)';
          card.style.boxShadow = 'none';
      });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const songItems = document.querySelectorAll('.song-item');

  if (songItems) {
      songItems.forEach((item) => {
          item.style.opacity = '1';
          item.style.transform = 'translateX(0)';
          item.style.transition = `opacity 0.5s ease, transform 0.5s ease`;

          item.addEventListener('mouseover', () => {
              item.style.opacity = '0.7'; 
              item.style.transform = 'translateX(10px)'; 
          });

          item.addEventListener('mouseout', () => {
              item.style.opacity = '1';
              item.style.transform = 'translateX(0)'; 
          });
      });
  }
});


// Edit Playlist Button Animation
document.addEventListener('DOMContentLoaded', () => {
  const editButton = document.querySelector('.edit-button');

  if (editButton) {
      editButton.addEventListener('mouseover', () => {
          editButton.style.transform = 'rotate(-5deg)';
          editButton.style.transition = 'transform 0.2s ease';
      });

      editButton.addEventListener('mouseout', () => {
          editButton.style.transform = 'rotate(0deg)';
      });

      editButton.addEventListener('click', () => {
          editButton.style.transform = 'scale(0.9)';
          setTimeout(() => {
              editButton.style.transform = 'scale(1)';
          }, 100);
      });
  }
});

// Add Songs Button Animation
document.addEventListener('DOMContentLoaded', () => {
  const addSongsButton = document.querySelector('.add-songs-button');

  if (addSongsButton) {
      addSongsButton.addEventListener('mouseover', () => {
          addSongsButton.style.animation = 'pulse 1s infinite';
      });

      addSongsButton.addEventListener('mouseout', () => {
          addSongsButton.style.animation = 'none';
      });

      addSongsButton.addEventListener('click', () => {
          addSongsButton.style.transform = 'translateX(10px)';
          addSongsButton.style.transition = 'transform 0.2s ease';
          setTimeout(() => {
              addSongsButton.style.transform = 'translateX(0)';
          }, 200);
      });
  }
});

// Playlist cover animation
document.addEventListener('DOMContentLoaded', () => {
  const playlistCovers = document.querySelectorAll('.playlist-cover');

  if (playlistCovers) {
      playlistCovers.forEach((cover) => {
          cover.addEventListener('mouseenter', () => {
              cover.classList.add('shining'); 
          });

          cover.addEventListener('mouseleave', () => {
              cover.classList.remove('shining');
          });
      });
  }
});

document.querySelectorAll(".pl-0").forEach(link => {
    link.addEventListener("mouseenter", () => {
      gsap.to(link, { scale: 1.2, color: "brown", duration: 0.3 });
    });
    link.addEventListener("mouseleave", () => {
      gsap.to(link, { scale: 1, color: "#ffffff", duration: 0.3 });
    });
  });