package ca.mcgill.ecse321.urlms.controller;

import static org.junit.Assert.*;

import java.io.File;

import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.model.URLMS;
import ca.mcgill.ecse321.urlms.persistence.PersistenceXStream;

public class PersistenceTest {

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
		URLMSApplication.setFilename("urlmsTest.xml");
		File file = new File("urlmsTest.xml");
		file.delete();
		PersistenceXStream.setFilename("urlmsTest.xml");
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
		File file = new File("urlmsTest.xml");
		file.delete();
	}

	@Before
	public void setUp() throws Exception {
	}

	@After
	public void tearDown() throws Exception {
	}

	@Test
	public void testPersistence() {
		PersistenceXStream.initializeModelManager("urlmsTest.xml");
		URLMS urlms = (URLMS) PersistenceXStream.loadFromXMLwithXStream();
		PersistenceXStream.saveToXMLwithXStream(urlms);
		
		
		String testName = urlms.getClass().getSimpleName();
		
		assertEquals("URLMS", testName);
		assertEquals("Lab", urlms.getLab(0).getName());
		assertEquals(1, urlms.getLabs().size());
		
	}

}
