package ca.mcgill.ecse321.urlms.view;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JTextField;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.JCheckBox;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JScrollPane;
import javax.swing.JLabel;

public class EditStaffMemberPO extends JFrame {

	private JPanel contentPane;
	private JTextField txtID;
	private JTextField txtNewName;
	private JTextField txtNewId;
	private JTextField txtNewSalary;
	public static StaffController controller = new StaffController();
	private JCheckBox ResearchAssistantBox = new JCheckBox("Research Assistant");
	
	private JCheckBox ResearchAssociateBox = new JCheckBox("Research Associate");
	private JButton btnDelete;
	private String error;
	private JLabel lblError;
	private JButton btnClose;
	private JButton btnEditMember;

	/**
	 * Create the frame.
	 */
	public EditStaffMemberPO() {
		initComponents();
	}
	
	private void initComponents(){
		setAlwaysOnTop(true);
		setResizable(false);
		setTitle("Edit Staff Member");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 568, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtID = new JTextField();
		txtID.setText("ID of target");
		txtID.setColumns(10);
		
		txtNewName = new JTextField();
		txtNewName.setText("New Name");
		txtNewName.setColumns(10);
		
		txtNewId = new JTextField();
		txtNewId.setText("New ID");
		txtNewId.setColumns(10);
		

		
		btnEditMember = new JButton("Edit Member");
		btnEditMember.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				String desiredName = txtNewName.getText();
				int newID;
				int targetID;
				try {
					newID = Integer.valueOf(txtNewId.getText());
				} catch (RuntimeException e3) {
					newID = -1;
				}
				try {
					targetID = Integer.valueOf(txtID.getText());
				} catch (RuntimeException e3) {
					targetID = -1;
				}
				boolean box1 = ResearchAssistantBox.isSelected();
				boolean box2 = ResearchAssociateBox.isSelected();
				
				double weeklySalary;
				try {
					weeklySalary = Double.valueOf(txtNewSalary.getText());
				} catch (RuntimeException e2) {
					weeklySalary = -1;
				}
				
				try {
					controller.editStaffmemberRecordByID(targetID, newID, desiredName, box1, box2, weeklySalary);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				}
				refreshData();
			}
		});
		
		txtNewSalary = new JTextField();
		txtNewSalary.setText("New Salary");
		txtNewSalary.setColumns(10);
		
		btnDelete = new JButton("Delete Member");
		btnDelete.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				int id;
				try {
					id = Integer.valueOf(txtID.getText());
					controller.removeStaffMemberByID(id);
				} catch (NumberFormatException | InvalidInputException e1) {
					error += "Invalid ID entered. ";
					error += e1.getMessage();
				}
				refreshData();
			}
			
		});
		
		JScrollPane scrollPane = new JScrollPane();
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent arg0) {
				close();
			}
		});
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.TRAILING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(34)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
								.addComponent(txtID, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
								.addComponent(btnDelete))
							.addGap(42)
							.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING)
								.addComponent(txtNewName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
								.addComponent(btnEditMember)))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 139, GroupLayout.PREFERRED_SIZE)
							.addGap(28)
							.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
								.addComponent(txtNewId, Alignment.TRAILING, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
								.addGroup(Alignment.TRAILING, gl_contentPane.createParallelGroup(Alignment.LEADING)
									.addComponent(ResearchAssistantBox, Alignment.TRAILING)
									.addComponent(ResearchAssociateBox, Alignment.TRAILING)
									.addComponent(txtNewSalary, Alignment.TRAILING, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)))))
					.addGap(54)
					.addComponent(btnClose)
					.addGap(59))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addContainerGap()
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
							.addGroup(gl_contentPane.createSequentialGroup()
								.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING)
									.addComponent(txtID, Alignment.LEADING, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
									.addGroup(gl_contentPane.createSequentialGroup()
										.addComponent(txtNewName, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
										.addGap(18)
										.addComponent(txtNewId, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
										.addGap(18)
										.addComponent(ResearchAssistantBox)
										.addPreferredGap(ComponentPlacement.RELATED)
										.addComponent(ResearchAssociateBox)
										.addPreferredGap(ComponentPlacement.RELATED)
										.addComponent(txtNewSalary, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)))
								.addPreferredGap(ComponentPlacement.RELATED, 31, Short.MAX_VALUE)
								.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
									.addComponent(btnEditMember, Alignment.TRAILING)
									.addComponent(btnDelete, Alignment.TRAILING))
								.addContainerGap())
							.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
								.addComponent(btnClose)
								.addGap(115)))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 128, GroupLayout.PREFERRED_SIZE)
							.addGap(66))))
		);
		
		lblError = new JLabel("Edit some staff.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Staff successfully edited/deleted.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
