<?php

namespace PruebaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PruebaBundle\Entity\Usuario;
use PruebaBundle\Entity\Rol;
use PruebaBundle\Form\UsuarioType;
use PruebaBundle\Form\RolType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function inicioPage()
    {
        return $this->render('usuario/index.html.twig');
    }

    /**
     * @Route("/registro/usuario", name="registrarUsuarios")
     */
    public function registrarUsuarios(Request $request)
    {
        $usuario = new Usuario();
        //crear el formulario 
        $form = $this->createForm(UsuarioType::class,$usuario);

        //recojer informacion 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //rellenar la entidad 
            $form = $form->getData();
            //almacenar nuevo registro 
            $elemento = $this->getDoctrine()->getManager();
            $elemento->persist($usuario);
            $elemento->flush();
            return $this->redirectToRoute('inicio');
        }
        return $this->render('usuario/registrarUsuarios.html.twig',array("form" => $form->createView()  ));
    }

    /**
     * @Route("/registro/roles", name="registrarRoles")
     */
    public function registrarRoles(Request $request)
    {
        $rol = new Rol();
        //crear el formulario 
        $form = $this->createForm(RolType::class,$rol);

        //recojer informacion 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //rellenar la entidad 
            $form = $form->getData();
            //almacenar nuevo registro 
            $elemento = $this->getDoctrine()->getManager();
            $elemento->persist($rol);
            $elemento->flush();
            return $this->redirectToRoute('inicio');
        }
        return $this->render('usuario/registrarRoles.html.twig',array("form" => $form->createView()  ));
    }
    /**
     * @Route("/consulta", name="consultarRegistros")
     */
    public function consultarRegistros()
    {
        $repositoryrol = $this->getDoctrine()->getRepository('PruebaBundle:Usuario');
        $rol = $repositoryrol->findAll();
    
        return $this->render('usuario/consultarRegistros.html.twig',array('registros'=>$rol));
    }
    /**
     * @Route("/consulta/{id}", name="consultarRegistrosID")
     */
    public function consultarRegistrosId(Request $request,$id)
    {
        $usuario = $this->getDoctrine()
        ->getRepository(Usuario::class)
        ->find($id);  
        //crear el formulario 
        $form = $this->createForm(UsuarioType::class,$usuario);

        //recojer informacion 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //rellenar la entidad 
            $form = $form->getData();
            //almacenar nuevo registro 
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            return $this->redirectToRoute('inicio');
        }
        return $this->render('usuario/actualizarDatos.html.twig',array("form" => $form->createView()  ));  
    }
    /**
     * @Route("/eliminar/{id}", name="eliminar")
     */
    public function eliminarRegistro($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Usuario::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        
        //return $this->render('usuario/consultarRegistros.html.twig',array('registros'=>$rol));
    }
}
