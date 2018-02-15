package ca.mcgill.ecse321.urlms.persistence;

import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;

import com.thoughtworks.xstream.XStream;

import ca.mcgill.ecse321.urlms.model.Lab;
import ca.mcgill.ecse321.urlms.model.URLMS;
import ca.mcgill.ecse321.urlms.view.NewSaveFilePO;

public abstract class PersistenceXStream {

	private static XStream xstream = new XStream();
	private static String filename;

	public static URLMS initializeModelManager(String fileName) {
		// Initialization for persistence
		URLMS urlms;
		setFilename(fileName);

        // load model if exists, create otherwise
        File file = new File(fileName);
        if (file.exists()) {
            urlms = (URLMS) loadFromXMLwithXStream();
        } else {
            try {
                file.createNewFile();
            } catch (IOException e) {
                e.printStackTrace();
                System.exit(1);
            }
            urlms = new URLMS();
            Lab aLab = new Lab("Lab", urlms);
            urlms.addLab(aLab);
            saveToXMLwithXStream(urlms);
        }
        return urlms;

	}

	public static boolean saveToXMLwithXStream(Object obj) {
		xstream.setMode(XStream.ID_REFERENCES);
		String xml = xstream.toXML(obj); // save our xml file

		try {
			FileWriter writer = new FileWriter(filename);
			writer.write(xml);
			writer.close();
			return true;
		} catch (IOException e) {
			return false;
		}
	}

	public static Object loadFromXMLwithXStream() {
		xstream.setMode(XStream.ID_REFERENCES);
		try {
			FileReader fileReader = new FileReader(filename); // load our xml file
																 
			return xstream.fromXML(fileReader);
		} catch (IOException e) {
			NewSaveFilePO nsfpo = new NewSaveFilePO();
			nsfpo.setVisible(true);
			return null;
		}
	}

	public static void setFilename(String fn) {
		filename = fn;
	}

}