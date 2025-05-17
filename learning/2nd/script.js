(() => {
  'use strict';

  const courses = [
    {
      id: 1,
      title: 'JavaScript Fundamentals',
      description: 'Learn the essentials of JS programming for web development.',
      thumbnail: 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=400&q=80',
      lessons: [
        'Introduction to JavaScript',
        'Variables and Data Types',
        'Functions and Scope',
        'DOM Manipulation',
        'Events and Listeners',
      ],
      videos: ['https://www.youtube.com/embed/W6NZfCO5SIk', 'https://www.youtube.com/embed/hdI2bqOjy3c']
    },
    {
      id: 2,
      title: 'HTML & CSS Basics',
      description: 'Build modern, responsive web pages with ease.',
      thumbnail: 'https://i.ytimg.com/vi/G3e-cpL7ofc/maxresdefault.jpg',
      lessons: ['Introduction to HTML', 'Structuring Web Pages', 'CSS Fundamentals', 'Flexbox and Grid', 'Responsive Design Basics'],
      videos: ['https://www.youtube.com/embed/mU6anWqZJcc']
    },
    {
      id: 3,
      title: 'Python for Beginners',
      description: 'Start coding in Python with step-by-step lessons.',
      thumbnail: 'https://i.pinimg.com/736x/8d/ce/be/8dcebedf391f14ac629a9c51d944e990.jpg',
      lessons: ['Getting Started with Python', 'Variables and Data Types', 'Control Flow and Loops', 'Functions and Modules', 'Working with Files'],
      videos: ['https://www.youtube.com/embed/_uQrJ0TkZlc']
    },
    {
      id: 4,
      title: 'UI/UX Design Fundamentals',
      description: 'Design beautiful user experiences by understanding the basics.',
      thumbnail: 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=400&q=80',
      lessons: ['What is UI/UX?', 'Design Principles', 'Wireframing and Prototyping', 'Color Theory', 'User Testing Basics'],
      videos: ['https://youtu.be/FlwYtS4mIQw?list=PLdvOfoe7PXT0ouChAnR1nHlT8BJIo5hP_']
    }
  ];

  let currentView = 'home';
  const navHomeBtn = document.getElementById('nav-home');
  const navLoginBtn = document.getElementById('nav-login');
  const courseListSection = document.getElementById('course-list');
  const courseDetailSection = document.getElementById('course-detail');
  const backBtn = courseDetailSection.querySelector('.back-btn');
  const courseDetailTitle = courseDetailSection.querySelector('h2');
  const courseDetailDesc = courseDetailSection.querySelector('p');
  const lessonsList = document.getElementById('lessons-list');

  const modalBg = document.getElementById('modal-bg');
  const modal = document.getElementById('modal');
  const modalTitle = modal.querySelector('h3');
  const authForm = document.getElementById('auth-form');
  const switchModeLink = modal.querySelector('#switch-to-register');
  const closeModalBtn = modal.querySelector('.close-btn');

  let authMode = 'login';

  const videoContainer = document.createElement('div');
  videoContainer.id = 'video-lectures';
  videoContainer.innerHTML = `<h3>Video Lectures</h3><div id="videos-wrapper"></div>`;
  lessonsList.after(videoContainer);

  function renderCourseCatalog() {
    courseListSection.innerHTML = '';
    courses.forEach(course => {
      const card = document.createElement('div');
      card.className = 'course-card';
      card.setAttribute('role', 'listitem');
      card.tabIndex = 0;
      card.dataset.courseId = course.id;
      card.innerHTML = `
        <img src="${course.thumbnail}" alt="Thumbnail for ${course.title}" class="course-thumb" />
        <div class="course-content">
          <div class="course-title">${course.title}</div>
          <div class="course-desc">${course.description}</div>
        </div>
      `;
      card.addEventListener('click', () => openCourseDetail(course.id));
      card.addEventListener('keydown', ev => {
        if (ev.key === 'Enter' || ev.key === " ") {
          ev.preventDefault();
          openCourseDetail(course.id);
        }
      });
      courseListSection.appendChild(card);
    });
  }

  function openCourseDetail(courseId) {
    const course = courses.find(c => c.id === courseId);
    if (!course) return;
    courseDetailTitle.textContent = course.title;
    courseDetailDesc.textContent = course.description;
    lessonsList.innerHTML = '';
    course.lessons.forEach(lesson => {
      const li = document.createElement('li');
      li.textContent = lesson;
      lessonsList.appendChild(li);
    });

    const videosWrapper = document.getElementById('videos-wrapper');
    videosWrapper.innerHTML = '';
    course.videos.forEach(videoURL => {
      const iframe = document.createElement('iframe');
      iframe.src = videoURL;
      iframe.width = '100%';
      iframe.height = '200';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
      iframe.allowFullscreen = true;
      iframe.style.border = 'none';
      iframe.style.marginBottom = '1rem';
      videosWrapper.appendChild(iframe);
    });

    transitionTo('courseDetail');
  }

  function backToCatalog() {
    transitionTo('home');
  }

  function transitionTo(view) {
    if (view === 'home') {
      courseDetailSection.classList.remove('active');
      courseListSection.style.display = 'grid';
      navHomeBtn.classList.add('active');
    } else {
      courseDetailSection.classList.add('active');
      courseListSection.style.display = 'none';
      navHomeBtn.classList.remove('active');
    }
    currentView = view;
  }

  function openModal(mode = 'login') {
    authMode = mode;
    updateModal();
    // modalBg.classList.add('active');
    modalBg.setAttribute('aria-hidden', 'false');
    authForm.reset();
    authForm.querySelector('input').focus();
  }

  function closeModal() {
    modalBg.classList.remove('active');
    modalBg.setAttribute('aria-hidden', 'true');
  }

  function updateModal() {
    modalTitle.textContent = authMode === 'login' ? 'Login' : 'Register';
    authForm.querySelector('button').textContent = authMode === 'login' ? 'Login' : 'Register';
    switchModeLink.textContent = authMode === 'login' ? 'Register here' : 'Login here';
  }

  function toggleAuthMode() {
    authMode = authMode === 'login' ? 'register' : 'login';
    updateModal();
  }

  function handleAuthSubmit(e) {
    e.preventDefault();
    const data = new FormData(authForm);
    const email = data.get('email');
    const password = data.get('password');
    if (!email || !password) {
      alert('Please enter email and password.');
      return;
    }
    // alert(`${authMode === 'login' ? 'Logged in' : 'Registered'} successfully as ${email}`);
    // closeModal();
  }

  navHomeBtn.addEventListener('click', () => transitionTo('home'));
  navLoginBtn.addEventListener('click', () => openModal('login'));
  backBtn.addEventListener('click', backToCatalog);
  switchModeLink.addEventListener('click', e => {
    e.preventDefault();
    toggleAuthMode();
  });
  closeModalBtn.addEventListener('click', closeModal);
  modalBg.addEventListener('click', e => {
    if (e.target === modalBg) closeModal();
  });
  authForm.addEventListener('submit', handleAuthSubmit);

  document.addEventListener('keydown', e => {
    if (modalBg.classList.contains('active') && e.key === 'Escape') closeModal();
  });

  renderCourseCatalog();
  transitionTo('home');
})();