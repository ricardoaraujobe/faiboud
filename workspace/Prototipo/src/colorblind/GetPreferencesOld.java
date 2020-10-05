package colorblind;

import java.io.FileWriter;
import java.util.Collection;
import java.util.Collections;
import java.util.Iterator;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;
import org.semanticweb.owlapi.model.OWLClassAssertionAxiom;
import org.semanticweb.owlapi.model.OWLDataFactory;
import org.semanticweb.owlapi.model.OWLDataProperty;
import org.semanticweb.owlapi.model.OWLDataPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLIndividual;
import org.semanticweb.owlapi.model.OWLNamedIndividual;
import org.semanticweb.owlapi.model.OWLObjectProperty;
import org.semanticweb.owlapi.model.OWLObjectPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLOntology;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.search.EntitySearcher;
import org.semanticweb.owlapi.util.OWLEntityRemover;
import org.semanticweb.owlapi.model.OWLLiteral;
import org.semanticweb.owlapi.reasoner.OWLReasoner;
import org.semanticweb.owlapi.reasoner.OWLReasonerFactory;
import com.clarkparsia.pellet.owlapiv3.PelletReasonerFactory;

public class GetPreferences {

	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
		   
        
        
        //String url = "file:////E:/mestrado/pesquisa/2016/Ontologias/producao/ColorBlindOntology.owl";
		String url = "file:////vagrant/workspace/Prototipo/src/ColorBlindOntology.owl";
		//variaveis
		String classOWL = "UserPreferences";   		
		String individualOWL = args[0];
		String result = args[1];

		
		String urlExportJSON ="/vagrant/www/includes/json/"+individualOWL+"_preference.json";
		String urlExportJSON2 ="/vagrant/www/includes/json/"+individualOWL+"_technique_preference.json";
		
		OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
		IRI iri = IRI.create(url);
		String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
		OWLDataFactory factory = manager.getOWLDataFactory(); //carrega fabrica de classes, axiomas, etc.
		PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
		//pm.setDefaultPrefix(IRI_BASE+"#");
		
		OWLClass cls = factory.getOWLClass(":"+classOWL, pm);

		OWLNamedIndividual user = factory.getOWLNamedIndividual(":"+individualOWL, pm);
		OWLObjectProperty hasPreferedColorChange = factory.getOWLObjectProperty(":hasPreferedColorChange",pm);
		Collection<OWLIndividual> cores = EntitySearcher.getObjectPropertyValues(user, hasPreferedColorChange, Ontology);
		OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		Iterator<OWLIndividual> icores = cores.iterator();
		
		JSONArray list_color = new JSONArray();
		JSONObject obj = new JSONObject();
		FileWriter file = new FileWriter(urlExportJSON);
		
        while (icores.hasNext()){
			OWLIndividual cor = icores.next();
			OWLObjectProperty hasOriginalColor = factory.getOWLObjectProperty(":hasOriginalColor", pm);
			Collection<OWLIndividual> originalColor = EntitySearcher.getObjectPropertyValues(cor, hasOriginalColor, Ontology);
			Iterator<OWLIndividual> idOriginalColor = originalColor.iterator();
			OWLIndividual orColor = idOriginalColor.next();


			System.out.println(renderer.render(cor)+" cor original "+renderer.render(orColor ));
			obj.put("preference", list_color);
			list_color.add(renderer.render(cor)+"-"+renderer.render(orColor ));
		}
		
		file.write(obj.toJSONString());
		file.flush();
		file.close();
		



		String classOWL2 = "Color";

		OWLReasonerFactory reasonerFactory = PelletReasonerFactory.getInstance();
		OWLReasoner reasoner = reasonerFactory.createReasoner(Ontology);


		@SuppressWarnings("unused")
		OWLClass colorClass = factory.getOWLClass(":"+classOWL2, pm);


		OWLClass actionClass = factory.getOWLClass(":"+result, pm);

		JSONArray list_color2 = new JSONArray();
		JSONObject obj2 = new JSONObject();
		FileWriter file2 = new FileWriter(urlExportJSON2);
		for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){


			System.out.println("Original Color: "+ renderer.render(action));
			OWLObjectProperty hasOriginalColor2 = factory.getOWLObjectProperty("isOriginalColor", pm);

			Collection<OWLIndividual>corOriginal = EntitySearcher.getObjectPropertyValues(action, hasOriginalColor2, Ontology);


			Iterator<OWLIndividual> idOriginalColor2 = corOriginal.iterator();
           while(idOriginalColor2.hasNext()){
				OWLIndividual orColor2 = idOriginalColor2.next();

			System.out.println(" -----Tecnica "+renderer.render(orColor2 ));


			obj2.put("technique", list_color2);
			list_color2.add(renderer.render(action)+"-"+renderer.render(orColor2 ));
			}

		}
		file2.write(obj2.toJSONString());
		file2.flush();
		file2.close();
	}
}
