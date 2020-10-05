package org.semanticweb.owlapi.examples;




import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.Writer;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;


import java.util.Collection;
import java.util.Iterator;

import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;
import org.semanticweb.owlapi.model.OWLClassAssertionAxiom;
import org.semanticweb.owlapi.model.OWLDataFactory;
import org.semanticweb.owlapi.model.OWLDataProperty;
import org.semanticweb.owlapi.model.OWLIndividual;
import org.semanticweb.owlapi.model.OWLLiteral;
import org.semanticweb.owlapi.model.OWLNamedIndividual;
import org.semanticweb.owlapi.model.OWLObjectProperty;
import org.semanticweb.owlapi.model.OWLObjectPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLOntology;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.search.EntitySearcher;



public class Examples {

	public static void main(String[] args )throws Exception {
		String url = "file:///E:/mestrado/pesquisa/2016/Ontologias/ColorBlindOntology_teste_v1.owl";
		
		//variaveis
		String classOWL = "PerceptedColor";
		String newClassOWL = "User";
		String individualOWL = "DADA2E_Prot";
		String propertyOWL = "colorCode";
		String objectPropertyOWL = "hasOriginalColor";
		String newIndividual = "Ricardo_002";
		String newObjectIndividual = "BBBBBB";
		String newDataProperty = "AAAAAA";
		
		
		OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
		IRI iri = IRI.create(url);
		String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
		OWLDataFactory factory = manager.getOWLDataFactory();
		PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
		pm.setDefaultPrefix(IRI_BASE+"#");
		
		//lista quantidade de individuos da classe
		OWLClass cls = factory.getOWLClass(":"+classOWL, pm);
		System.out.println("Ontologia: " + cls.getIRI());
		Collection<OWLIndividual> individual = EntitySearcher.getIndividuals(cls, Ontology);
		System.out.println("Quantidade de individuos: " + individual.size());
		Iterator<OWLIndividual> idindividual = individual.iterator();
		OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		while (idindividual.hasNext()){
			OWLIndividual ind = idindividual.next();
			System.out.println(renderer.render(ind));
			
		}
		//lista propriedade de um individuo
		OWLIndividual idv = factory.getOWLNamedIndividual(":"+individualOWL, pm);
		OWLDataProperty dtPr = factory.getOWLDataProperty(IRI.create(pm.getDefaultPrefix() + propertyOWL));
		Collection<OWLLiteral> valueDtPr = EntitySearcher.getDataPropertyValues(idv, dtPr, Ontology);
		Iterator<OWLLiteral> idDtPr = valueDtPr.iterator();
		while (idDtPr.hasNext()){
			OWLLiteral dp = idDtPr.next();
			
			
			//Escrever no arquivo JSON
			/**Writer writer = new FileWriter("E:/mestrado/pesquisa/2016/prototipo/Output.json");
			Gson gson = new GsonBuilder().create();
	        gson.toJson("Cor original: "+dp.getLiteral()+"\n\n", writer);
	        gson.toJson("Cor percebida: "+renderer.render(idv), writer);

	        writer.close();**/
			
			
			
			System.out.println("O valor de " + renderer.render(idv)+ " é: " + dp.getLiteral());
			
		}
		/**
		//lista objeto
		OWLObjectProperty oPr = factory.getOWLObjectProperty(":"+objectPropertyOWL, pm);
		Collection<OWLIndividual> obPrp = EntitySearcher.getObjectPropertyValues(idv, oPr, Ontology);		
		Iterator<OWLIndividual> idObPrp = obPrp.iterator();
		while (idObPrp.hasNext()){
			OWLIndividual op = idObPrp.next();
			System.out.println(" " + renderer.render(op) +" "+ objectPropertyOWL +" "+ renderer.render(idv));

		}
		
		//cria um novo indivíduo
		
		OWLNamedIndividual newInd = factory.getOWLNamedIndividual(":"+newIndividual, pm);
		OWLClassAssertionAxiom classAssertion = factory.getOWLClassAssertionAxiom(cls, newInd);
		manager.addAxiom(Ontology, classAssertion);
		manager.saveOntology(Ontology);
		System.out.println(newIndividual+" inserido em "+classOWL);
		
		
		//Insere propriedade ao individuo
		OWLNamedIndividual newIndiv = factory.getOWLNamedIndividual(":"+newObjectIndividual, pm);
		OWLObjectPropertyAssertionAxiom propertyAssertion = factory.getOWLObjectPropertyAssertionAxiom(oPr, newInd, newIndiv);
		System.out.println(newIndiv+" " + oPr +" " + newInd);
		
		manager.addAxiom(Ontology, propertyAssertion);
		manager.saveOntology(Ontology);**/
		
		
	}

	
	
	
	
	
	
	

}


