<?php
namespace AppBundle\Controller\Web;


use AppBundle\Entity\Book;
use AppBundle\Entity\Goal;
use AppBundle\Entity\Shelf;
use AppBundle\Entity\Timeline;
use AppBundle\Entity\User;
use AppBundle\Entity\UserBook;
use AppBundle\Entity\UserBookShelf;
use AppBundle\Form\AvatarType;
use AppBundle\Form\UserBookType;
use AppBundle\Form\UserType;
use AppBundle\Form\GoalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="user_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('diar');
    }

    /**
     * @Route("/me", name="my_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class, $this->getUser());

        $goal = $em->getRepository(Goal::class)->findCurrentGoal();
        $goalForm = $this->createForm(GoalType::class, $goal, [
            'action' => $this->generateUrl('create_new_goal'),
            'method' => 'post'
        ]);

        $avatar = $this->createForm(AvatarType::class, new User(), [
            'method' => 'POST',
            'action' => $this->generateUrl('insert_new_avatar')
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Your profile is updated..');
        }


        $timeline = $em->getRepository(Timeline::class)->getAllAndOrderByLatest(5);

        return $this->render('@App/user/profile.html.twig', [
            'timeline' => $timeline,
            'profile' => $form->createView(),
            'avatar' => $avatar->createView(),
            'goalForm' => $goalForm->createView()
        ]);
    }

    /**
     * @Route("/me/books", name="my_shelfed_books")
     */
    public function myBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $shelfs = $em->getRepository(Shelf::class)->findByUser($this->getUser()->getId());

        return $this->render('@App/user/my-books.html.twig', [
            'shelfs' => $shelfs
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/register", name="register_user")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createUserForm($user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            //set the password to hash
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $fileName = $this->get('app.avatar_uploader')
                ->upload($request->files->get('user')['avatar']);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $user->setAvatar($fileName);


            $em = $this->getDoctrine()->getManager();
            $this->addFlash('success', 'The user has been registred...');
            $user->setCreatedAt(new \DateTime('now'));
            $em->persist($user);
            $em->flush();
        }
        return $this->render('@App/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Form builder
     */
    public function createUserForm($class, $url = 'register_user', $options = array())
    {
        return $this->createForm(UserType::class, $class, [
            'action' => $this->generateUrl($url, $options),
            'method' => 'POST'
        ])->add('save', SubmitType::class);
    }

    /**
     * @Route("/books/added", name="my_added_books")
     */
    public function myAddedBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository(Book::class)->findUsersBooks($this->getUser());

        return $this->render('AppBundle:user:my_books.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @param Request $request
     * @Route("/me/new/avatar", name="insert_new_avatar")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function avatarAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(AvatarType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

           $fileName = $this->get('app.avatar_uploader')
               ->upload($request->files->get('avatar')['avatar']);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $user->setAvatar($fileName);

            // ... persist the $product variable or any other work
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Updated successfuly.');

            return $this->redirect($this->generateUrl('my_profile'));
        }
    }

    /**
     * @param Book $book
     * @Route("/addowner/{id}", name="add_owner_for_book")
     */
    public function addBookAction(Request $request, Book $book)
    {
        $em = $this->getDoctrine()->getManager();

        $userBook = $this->createForm(UserBookType::class);
        $userBook->handleRequest($request);
        if($userBook->isValid()){
            $userBook = $userBook->getData();
            $userBook->setUser($this->getUser());
            $userBook->setBook($book);
            $em->persist($userBook);
            $em->flush();
            $this->addFlash('success', 'Great job, others will contact you soon.');
        }

        return $this->redirectToRoute('view_the_book',['slug' => $book->getSlug()]);
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/{id}", name="visit_member_profile")
     */
    public function visitAction(User $user)
    {
        return $this->render('@App/user/user.html.twig', ['user' => $user]);
    }

}